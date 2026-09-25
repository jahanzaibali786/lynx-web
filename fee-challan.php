<?php
/**
 * The Lynx School - Fee Challan Portal (PHP Backend & Frontend)
 */
error_reporting(E_ALL & ~E_NOTICE);

$db_connected = false;
$conn = null;
if (file_exists(__DIR__ . '/connection.php')) {
    include_once __DIR__ . '/connection.php';
    if (isset($conn) && $conn instanceof mysqli && !$conn->connect_error) {
        $db_connected = true;
    }
}

// Dynamic Month: After 25th auto next month
$currentDay = (int)date('j');
if ($currentDay > 25) {
    $challanMonth = date('F', strtotime('first day of next month'));
    $challanYear = date('Y', strtotime('first day of next month'));
} else {
    $challanMonth = date('F');
    $challanYear = date('Y');
}

// Local AJAX proxy if needed
if (isset($_GET['action']) && $_GET['action'] === 'fetch_children') {
    header('Content-Type: application/json');
    $cnic = trim($_GET['cnic'] ?? '');
    $cleanCnic = str_replace('-', '', $cnic);
    $children = [];

    if ($db_connected && !empty($cnic)) {
        $sql = "SELECT sr.id, sr.reg_no, sr.roll_no, sr.stdname AS name, sr.fathername AS father_name, sr.mothername AS mother_name,
                       c.name AS class_name, cs.section_name, b.name AS branch_name
                FROM student_registrations sr
                LEFT JOIN classes c ON c.id = sr.class_id
                LEFT JOIN class_sections cs ON cs.id = sr.section_id
                LEFT JOIN users b ON b.id = sr.owned_by
                WHERE (REPLACE(sr.fathercnic, '-', '') = ? OR REPLACE(sr.mothercnic, '-', '') = ? OR sr.fathercnic = ? OR sr.mothercnic = ?)
                  AND (sr.active_status = 1 OR sr.student_status = '1' OR sr.student_status = 'Enrolled')
                ORDER BY sr.id ASC";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param('ssss', $cleanCnic, $cleanCnic, $cnic, $cnic);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $children[] = [
                    'id' => $row['id'],
                    'student_id' => $row['id'],
                    'name' => $row['name'],
                    'student_name' => $row['name'],
                    'roll_no' => $row['roll_no'] ?? '',
                    'registration_no' => $row['reg_no'] ?? ('TLS-' . $row['id']),
                    'reg_no' => $row['reg_no'] ?? ('TLS-' . $row['id']),
                    'father_name' => $row['father_name'],
                    'mother_name' => $row['mother_name'],
                    'class_name' => $row['class_name'] ?? 'Primary',
                    'section_name' => $row['section_name'] ?? 'A',
                    'branch_name' => $row['branch_name'] ?? 'The Lynx School Branch'
                ];
            }
            $stmt->close();
        }
    }

    echo json_encode([
        'success' => true,
        'count' => count($children),
        'data' => $children
    ]);
    exit();
}

if (isset($_GET['action']) && $_GET['action'] === 'fetch_challan') {
    header('Content-Type: application/json');
    $studentId = (int)($_GET['student_id'] ?? 0);
    $reqMonth = trim($_GET['month'] ?? '');
    $reqYear = trim($_GET['year'] ?? '');

    $targetYear = !empty($reqYear) ? (int)$reqYear : (int)date('Y');
    $targetMonthNum = null;
    if (!empty($reqMonth)) {
        if (is_numeric($reqMonth)) {
            $targetMonthNum = (int)$reqMonth;
        } else {
            $ts = strtotime("1 {$reqMonth} {$targetYear}");
            if ($ts !== false) {
                $targetMonthNum = (int)date('n', $ts);
            }
        }
    }
    if (!$targetMonthNum) {
        $targetMonthNum = ((int)date('j') > 25) ? (int)date('n', strtotime('first day of next month')) : (int)date('n');
        $targetYear = ((int)date('j') > 25) ? (int)date('Y', strtotime('first day of next month')) : (int)date('Y');
    }

    $formattedMonthString = sprintf('%04d-%02d', $targetYear, $targetMonthNum);
    $monthNameStr = date('F', mktime(0, 0, 0, $targetMonthNum, 1, $targetYear));

    $challanData = null;
    if ($db_connected && $studentId > 0) {
        // Fetch student
        $stdSql = "SELECT sr.id, sr.reg_no, sr.roll_no, sr.stdname AS name, sr.fathername AS father_name,
                          c.name AS class_name, cs.section_name, b.name AS branch_name
                   FROM student_registrations sr
                   LEFT JOIN classes c ON c.id = sr.class_id
                   LEFT JOIN class_sections cs ON cs.id = sr.section_id
                   LEFT JOIN users b ON b.id = sr.owned_by
                   WHERE sr.id = ? LIMIT 1";
        $stdStmt = $conn->prepare($stdSql);
        $stdStmt->bind_param('i', $studentId);
        $stdStmt->execute();
        $stdRes = $stdStmt->get_result()->fetch_assoc();
        $stdStmt->close();

        if ($stdRes) {
            // Find challan for this month
            $chSql = "SELECT * FROM challans 
                      WHERE student_id = ? 
                        AND (fee_month LIKE ? OR fee_month LIKE ?)
                        AND challan_type NOT IN ('Registration')
                      ORDER BY id DESC LIMIT 1";
            $monthLike1 = $formattedMonthString . '%';
            $monthLike2 = '%' . $monthNameStr . '%';
            $chStmt = $conn->prepare($chSql);
            $chStmt->bind_param('iss', $studentId, $monthLike1, $monthLike2);
            $chStmt->execute();
            $challan = $chStmt->get_result()->fetch_assoc();
            $chStmt->close();

            // Fallback to latest challan
            if (!$challan) {
                $chSql2 = "SELECT * FROM challans WHERE student_id = ? AND challan_type NOT IN ('Registration') ORDER BY id DESC LIMIT 1";
                $chStmt2 = $conn->prepare($chSql2);
                $chStmt2->bind_param('i', $studentId);
                $chStmt2->execute();
                $challan = $chStmt2->get_result()->fetch_assoc();
                $chStmt2->close();
            }

            if ($challan) {
                $challanId = (int)$challan['id'];
                // Heads
                $heads = [];
                $hSql = "SELECT ch.price, ch.concession, fh.fee_head
                         FROM challan_heads ch
                         LEFT JOIN fee_heads fh ON fh.id = ch.head_id
                         WHERE ch.challan_id = ?";
                $hStmt = $conn->prepare($hSql);
                $hStmt->bind_param('i', $challanId);
                $hStmt->execute();
                $hRes = $hStmt->get_result();
                $grossBilled = 0;
                $totalConcession = 0;
                while ($hRow = $hRes->fetch_assoc()) {
                    $p = (float)$hRow['price'];
                    $c = (float)$hRow['concession'];
                    $heads[] = [
                        'head_name' => $hRow['fee_head'] ?? 'Fee Head',
                        'fee_head' => $hRow['fee_head'] ?? 'Fee Head',
                        'amount' => $p,
                        'price' => $p,
                        'concession' => $c,
                        'net_amount' => max(0, $p - $c)
                    ];
                    $grossBilled += $p;
                    $totalConcession += $c;
                }
                $hStmt->close();

                // Arrears
                $challanFeeDate = !empty($challan['fee_month']) ? date('Y-m-01', strtotime($challan['fee_month'])) : ($formattedMonthString . '-01');
                $arrSql = "SELECT id, challanNo, fee_month, total_amount, paid_amount, concession_amount
                           FROM challans
                           WHERE student_id = ? AND id != ? AND status != 'Paid' AND challan_type NOT IN ('Registration')
                             AND STR_TO_DATE(fee_month, '%Y-%m-%d') < ?
                           ORDER BY id ASC";
                $arrStmt = $conn->prepare($arrSql);
                $arrStmt->bind_param('iis', $studentId, $challanId, $challanFeeDate);
                $arrStmt->execute();
                $arrRes = $arrStmt->get_result();
                $totalArrears = 0;
                $arrearsList = [];
                while ($aRow = $arrRes->fetch_assoc()) {
                    $due = max(0, (float)$aRow['total_amount'] - (float)$aRow['paid_amount'] - (float)$aRow['concession_amount']);
                    if ($due > 0) {
                        $totalArrears += $due;
                        $arrearsList[] = [
                            'challan_id' => $aRow['id'],
                            'challan_no' => $aRow['challanNo'],
                            'fee_month' => $aRow['fee_month'],
                            'amount' => $due
                        ];
                    }
                }
                $arrStmt->close();

                $netCurrent = max(0, (float)$challan['total_amount'] - (float)$challan['concession_amount']);
                $paid = (float)$challan['paid_amount'];
                $payableByDue = max(0, $netCurrent - $paid) + $totalArrears;
                $lateFee = 500;
                $payableAfterDue = $payableByDue + $lateFee;

                $challanData = [
                    'challan' => [
                        'id' => $challan['id'],
                        'challan_no' => $challan['challanNo'] ?? ('TLS-' . $challan['id']),
                        'challanNo' => $challan['challanNo'] ?? ('TLS-' . $challan['id']),
                        'challan_type' => $challan['challan_type'] ?? 'Monthly Fee',
                        'fee_month' => $challan['fee_month'],
                        'billing_month' => !empty($challan['fee_month']) ? date('F Y', strtotime($challan['fee_month'])) : "{$monthNameStr} {$targetYear}",
                        'issue_date' => $challan['issue_date'] ?: ($challan['challan_date'] ?: date('Y-m-d')),
                        'due_date' => $challan['due_date'] ?: date('Y-m-10', strtotime($challanFeeDate)),
                        'status' => $challan['status'] ?? 'Unpaid',
                        'total_amount' => (float)$challan['total_amount'],
                        'concession_amount' => (float)$challan['concession_amount'],
                        'paid_amount' => (float)$challan['paid_amount'],
                    ],
                    'student' => [
                        'id' => $stdRes['id'],
                        'name' => $stdRes['name'],
                        'student_name' => $stdRes['name'],
                        'roll_no' => $stdRes['roll_no'] ?? '',
                        'registration_no' => $stdRes['reg_no'] ?? ('TLS-' . $stdRes['id']),
                        'reg_no' => $stdRes['reg_no'] ?? ('TLS-' . $stdRes['id']),
                        'father_name' => $stdRes['father_name'],
                        'class_name' => $stdRes['class_name'] ?? 'Primary',
                        'section_name' => $stdRes['section_name'] ?? 'A',
                        'branch_name' => $stdRes['branch_name'] ?? 'The Lynx School',
                    ],
                    'heads' => $heads,
                    'fee_heads' => $heads,
                    'arrears' => [
                        'total_amount' => $totalArrears,
                        'count' => count($arrearsList),
                        'breakdown' => $arrearsList
                    ],
                    'arrears_amount' => $totalArrears,
                    'summary' => [
                        'gross_amount' => $grossBilled,
                        'total_concession' => $totalConcession,
                        'net_fee' => $netCurrent,
                        'arrears_amount' => $totalArrears,
                        'payable_by_due_date' => $payableByDue,
                        'late_fee' => $lateFee,
                        'payable_after_due_date' => $payableAfterDue,
                    ],
                    'bank_info' => [
                        'bank_name' => 'Askari Bank Limited',
                        'account_no' => '0012-0100-345678',
                        'branch_name' => 'Corporate Branch',
                    ],
                    'download_url' => "challan/show/{$challan['id']}?type=print"
                ];
            }
        }
    }

    if ($challanData) {
        echo json_encode(['success' => true, 'data' => $challanData]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Challan not found']);
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fee Challan Portal - The Lynx School</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alex+Brush&family=Great+Vibes&family=Montserrat:wght@400;500;600;700;800&family=Nunito+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        @import url('https://fonts.cdnfonts.com/css/edwardian-script-itc');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Nunito Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            min-height: 100vh;
            width: 100vw;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #dfd8cf;
            background-image: url('assets/img/challan-bg.jpg');
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            position: relative;
            overflow-x: hidden;
            padding: 30px 15px;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(245, 242, 237, 0.52);
            backdrop-filter: blur(1.5px);
            -webkit-backdrop-filter: blur(1.5px);
            z-index: 1;
        }

        .main-wrapper {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 600px;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: auto;
        }

        .challan-card {
            background: #ffffff;
            width: 100%;
            border-radius: 8px;
            box-shadow: 0 6px 28px rgba(0, 0, 0, 0.1), 0 1px 4px rgba(0, 0, 0, 0.05);
            padding: 36px 42px 34px 42px;
            transition: all 0.3s ease;
        }

        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            margin-bottom: 22px;
            text-decoration: none;
        }

        .logo-img {
            height: 62px;
            width: auto;
            object-fit: contain;
            flex-shrink: 0;
        }

        .logo-text-cursive {
            font-family: 'Edwardian Script ITC', 'Great Vibes', 'Alex Brush', cursive;
            font-size: 46px;
            line-height: 1;
            color: #1a1a1a;
            font-weight: 500;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        .challan-month {
            color: #ee6f7d;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 20px;
            letter-spacing: 0.1px;
            text-align: left;
        }

        .parent-info-badge {
            display: none;
            background: #f1f5f9;
            border-left: 4px solid #3b82f6;
            border-radius: 4px;
            padding: 10px 14px;
            margin-bottom: 16px;
            font-size: 13.5px;
            color: #1e293b;
            animation: fadeIn 0.3s ease;
        }
        .parent-info-badge strong {
            color: #0f172a;
        }

        .form-group {
            margin-bottom: 16px;
            text-align: left;
        }

        .form-group label {
            display: block;
            font-size: 13.5px;
            font-weight: 800;
            color: #1a1a1a;
            margin-bottom: 7px;
            letter-spacing: 0.1px;
        }

        .input-control {
            width: 100%;
            height: 42px;
            padding: 8px 14px;
            font-size: 14px;
            font-family: inherit;
            color: #334155;
            background-color: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 5px;
            outline: none;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .input-control::placeholder {
            color: #94a3b8;
            font-size: 13.5px;
            font-weight: 400;
        }

        .input-control:focus {
            border-color: #4caf50;
            box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.18);
        }

        select.input-control {
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23334155' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 14px center;
            background-size: 16px;
            padding-right: 40px;
            font-weight: 600;
        }

        .children-list-container {
            display: none;
            margin-top: 16px;
            animation: fadeIn 0.3s ease-in-out forwards;
            text-align: left;
        }

        .children-list-header {
            font-size: 13px;
            font-weight: 700;
            color: #475569;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .child-cards-grid {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .child-card-item {
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px 16px;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            text-align: left;
            position: relative;
        }

        .child-card-item:hover {
            border-color: #3b82f6;
            background-color: #f8fafc;
            transform: translateY(-2px);
            box-shadow: 0 4px 14px rgba(59, 130, 246, 0.12);
        }

        .child-card-item.active {
            border-color: #2563eb;
            background-color: #f0f7ff;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.22);
        }

        .child-info-left {
            display: flex;
            flex-direction: column;
            gap: 5px;
            flex: 1;
        }

        .child-card-name {
            font-size: 14px;
            font-weight: 700;
            color: #0f172a;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
        }

        .child-badge {
            background: #e0f2fe;
            color: #0284c7;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.2px;
        }

        .child-card-meta {
            font-size: 12px;
            color: #64748b;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 8px;
        }

        .btn-open-details {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #2563eb;
            color: #ffffff;
            font-size: 12px;
            font-weight: 600;
            padding: 7px 14px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            white-space: nowrap;
            transition: all 0.2s ease;
            box-shadow: 0 1px 3px rgba(37, 99, 235, 0.2);
        }

        .child-card-item:hover .btn-open-details {
            background: #1d4ed8;
            box-shadow: 0 2px 6px rgba(29, 78, 216, 0.3);
        }

        .child-card-item.active .btn-open-details {
            background: #16a34a;
            box-shadow: 0 2px 6px rgba(22, 163, 74, 0.3);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-action {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 12px;
            margin-top: 20px;
        }

        .btn-search {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            background-color: #4caf50;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            padding: 9px 24px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
        }

        .btn-search:hover {
            background-color: #43a047;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }

        .btn-search:active {
            transform: translateY(1px);
        }

        .btn-reset {
            display: none;
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #cbd5e1;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-reset:hover {
            background: #e2e8f0;
            color: #1e293b;
        }

        .status-alert {
            display: none;
            margin-top: 14px;
            padding: 11px 15px;
            border-radius: 5px;
            font-size: 13px;
            line-height: 1.4;
            text-align: left;
        }
        .status-alert.error {
            background-color: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
            display: block;
        }
        .status-alert.success {
            background-color: #f0fdf4;
            color: #15803d;
            border: 1px solid #bbf7d0;
            display: block;
        }

        .challan-result-box {
            display: none;
            margin-top: 24px;
            border-top: 2px dashed #cbd5e1;
            padding-top: 20px;
            animation: fadeIn 0.4s ease-in-out;
            text-align: left;
        }

        .challan-voucher {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.05);
        }

        .voucher-header {
            background: #1e293b;
            color: #ffffff;
            padding: 14px 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .voucher-title {
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 0.2px;
        }

        .voucher-status-badge {
            font-size: 11px;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 12px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }
        .voucher-status-badge.issued {
            background: #fef3c7;
            color: #92400e;
        }
        .voucher-status-badge.paid {
            background: #dcfce7;
            color: #166534;
        }
        .voucher-status-badge.overdue {
            background: #fee2e2;
            color: #991b1b;
        }

        .voucher-body {
            padding: 18px 20px;
            background: #ffffff;
        }

        .meta-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px 16px;
            padding-bottom: 14px;
            border-bottom: 1px solid #f1f5f9;
        }

        .meta-item {
            display: flex;
            flex-direction: column;
        }

        .meta-label {
            font-size: 11px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .meta-val {
            font-size: 13.5px;
            font-weight: 700;
            color: #0f172a;
            margin-top: 2px;
        }

        .heads-section {
            margin-top: 14px;
        }

        .section-subtitle {
            font-size: 12px;
            font-weight: 800;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .heads-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12.5px;
            margin-bottom: 12px;
        }

        .heads-table th {
            background: #f1f5f9;
            color: #475569;
            font-weight: 700;
            text-align: left;
            padding: 7px 10px;
            border-top: 1px solid #e2e8f0;
            border-bottom: 1px solid #e2e8f0;
            font-size: 11.5px;
        }

        .heads-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #f1f5f9;
            color: #1e293b;
        }

        .heads-table td.amount-col {
            text-align: right;
            font-weight: 600;
        }

        .financial-summary-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 12px 16px;
            margin-top: 10px;
        }

        .fin-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
            color: #475569;
            margin-bottom: 6px;
        }

        .fin-row.discount {
            color: #dc2626;
            font-weight: 600;
        }

        .fin-row.payable-main {
            border-top: 1px dashed #cbd5e1;
            padding-top: 8px;
            margin-top: 8px;
            margin-bottom: 4px;
        }

        .payable-title {
            font-size: 14px;
            font-weight: 800;
            color: #0f172a;
        }

        .payable-amount {
            font-size: 19px;
            font-weight: 800;
            color: #15803d;
        }

        .fin-row.late-payable {
            font-size: 12px;
            color: #64748b;
        }

        .bank-info-bar {
            margin-top: 12px;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 5px;
            padding: 9px 12px;
            font-size: 11.5px;
            color: #1e40af;
            line-height: 1.5;
        }

        .voucher-actions {
            display: flex;
            padding: 16px 20px;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
        }

        .btn-action-download {
            width: 100%;
            background: #1e3a8a;
            color: #ffffff;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
            transition: all 0.2s ease;
            box-shadow: 0 2px 6px rgba(30, 58, 138, 0.25);
        }
        .btn-action-download:hover {
            background: #1e40af;
            box-shadow: 0 4px 10px rgba(30, 64, 175, 0.35);
            transform: translateY(-1px);
        }
        .btn-action-download:active {
            transform: translateY(0);
        }

        .footer-text {
            margin-top: 24px;
            font-size: 13.5px;
            font-weight: 600;
            color: #ffffff;
            text-align: center;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.7);
            letter-spacing: 0.1px;
        }

        @media (max-width: 576px) {
            body {
                padding: 15px;
            }
            .challan-card {
                padding: 26px 18px 22px 18px;
            }
            .logo-text-cursive {
                font-size: 36px;
            }
            .logo-img {
                height: 50px;
            }
            .meta-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <div class="main-wrapper">
        <div class="challan-card">
            
            <!-- The Lynx School Logo -->
            <a href="index.php" style="text-decoration: none; color: inherit; display: block;">
                <div class="logo-container">
                    <img src="assets/img/lnxlogo-removebg-preview(1).png" alt="The Lynx School Crest" class="logo-img">
                    <div class="logo-text-cursive">The Lynx School</div>
                </div>
            </a>

            <!-- Dynamic Fee Challan Month -->
            <div class="challan-month" id="challanMonthText">
                Fee Challan Month Of <?php echo "{$challanMonth} {$challanYear}"; ?>
            </div>

            <!-- Form -->
            <form id="challanForm" onsubmit="handleFormSubmit(event)">
                
                <!-- Parents CNIC Field -->
                <div class="form-group" id="cnicGroup">
                    <label for="cnic">Parents CNIC No. Format(XXXXX-XXXXXXX-X)</label>
                    <input 
                        type="text" 
                        id="cnic" 
                        name="cnic" 
                        class="input-control" 
                        placeholder="XXXXX-XXXXXXX-X" 
                        maxlength="15" 
                        autocomplete="off" 
                        required
                    >
                </div>

                <!-- Verified Parent Name Display -->
                <div class="parent-info-badge" id="parentInfoBadge">
                    <i class="fa-solid fa-user-check" style="color: #3b82f6; margin-right: 6px;"></i>
                    <span>Parent: <strong id="displayParentName">-</strong></span>
                </div>

                <!-- Children Cards List on CNIC Search -->
                <div class="children-list-container" id="childrenListGroup">
                    <div class="children-list-header">
                        <i class="fa-solid fa-users" style="color: #3b82f6;"></i>
                        <span>Select a student to open details:</span>
                    </div>
                    <div class="child-cards-grid" id="childCardsList">
                        <!-- Populated dynamically on CNIC search -->
                    </div>
                </div>

                <div id="statusAlert" class="status-alert"></div>

                <div class="form-action">
                    <button type="button" class="btn-reset" id="resetBtn" onclick="resetForm()">
                        <i class="fa-solid fa-rotate-left"></i> Change CNIC
                    </button>
                    <button type="submit" class="btn-search" id="searchBtn">
                        <span id="searchBtnText">Search</span>
                        <i class="fa-solid fa-check" id="searchBtnIcon"></i>
                    </button>
                </div>
            </form>

            <!-- Detailed Challan Voucher Presentation Display -->
            <div class="challan-result-box" id="challanResultBox">
                <div class="challan-voucher">
                    
                    <div class="voucher-header">
                        <div>
                            <div class="voucher-title" id="voucherBillingMonth">Fee Challan - September, 2026</div>
                            <div style="font-size: 11.5px; opacity: 0.85; margin-top: 2px;">
                                Challan #: <strong id="voucherChallanNo">-</strong>
                            </div>
                        </div>
                        <span class="voucher-status-badge issued" id="voucherStatusBadge">Issued</span>
                    </div>

                    <div class="voucher-body">
                        <div class="meta-grid">
                            <div class="meta-item">
                                <span class="meta-label">Student Name</span>
                                <span class="meta-val" id="voucherStudentName">-</span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">Father / Parent Name</span>
                                <span class="meta-val" id="voucherFatherName">-</span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">Roll No / Reg No</span>
                                <span class="meta-val" id="voucherRollReg">-</span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">Class & Section</span>
                                <span class="meta-val" id="voucherClassSection">-</span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">Branch</span>
                                <span class="meta-val" id="voucherBranchName">-</span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">Due Date</span>
                                <span class="meta-val" id="voucherDueDate" style="color: #b91c1c;">-</span>
                            </div>
                        </div>

                        <div class="heads-section">
                            <div class="section-subtitle">Fee Heads Breakdown</div>
                            <table class="heads-table">
                                <thead>
                                    <tr>
                                        <th>Fee Head</th>
                                        <th style="text-align: right;">Amount (PKR)</th>
                                    </tr>
                                </thead>
                                <tbody id="voucherHeadsTbody"></tbody>
                            </table>
                        </div>

                        <div class="financial-summary-card">
                            <div class="fin-row payable-main">
                                <div>
                                    <div class="payable-title">Payable by Due Date</div>
                                    <div style="font-size: 11px; color: #64748b;">(Within Due Date)</div>
                                </div>
                                <div class="payable-amount" id="finPayableAmount">PKR 0</div>
                            </div>
                        </div>

                        <div class="bank-info-bar" id="bankInfoBar">
                            <div><i class="fa-solid fa-building-columns"></i> <strong>Bank:</strong> <span id="bankNameTitle">-</span></div>
                            <div><strong>Account #:</strong> <span id="bankAccountNo">-</span> | <strong>Branch:</strong> <span id="bankBranchAddr">-</span></div>
                        </div>
                    </div>

                    <!-- Single Full Width Download PDF Button -->
                    <div class="voucher-actions">
                        <a href="javascript:void(0)" id="voucherDownloadBtn" class="btn-action-download" target="_blank">
                            <i class="fa-solid fa-file-pdf"></i> Download PDF Challan
                        </a>
                    </div>

                </div>
            </div>

        </div>

        <div class="footer-text">
            Copyright &copy; <?php echo date('Y'); ?>, The Lynx School.
        </div>
    </div>

    <script>
        const API_BASE_URL = 'https://erp.thelynxschool.edu.pk/api/public/v1';

        function updateChallanMonthHeader() {
            const today = new Date();
            const currentDay = today.getDate();
            let targetDate = new Date(today.getFullYear(), today.getMonth(), 1);
            if (currentDay > 25) {
                targetDate.setMonth(targetDate.getMonth() + 1);
            }
            const monthNames = [
                "January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];
            const monthName = monthNames[targetDate.getMonth()];
            const year = targetDate.getFullYear();
            
            const monthHeaderElem = document.getElementById('challanMonthText');
            if (monthHeaderElem) {
                monthHeaderElem.textContent = `Fee Challan Month Of ${monthName} ${year}`;
            }
            return { monthName, year };
        }

        const activeChallanPeriod = updateChallanMonthHeader();

        const cnicInput = document.getElementById('cnic');
        cnicInput.addEventListener('input', function (e) {
            let val = e.target.value.replace(/\D/g, '');
            if (val.length > 13) val = val.substring(0, 13);
            let res = '';
            if (val.length > 0) res += val.substring(0, Math.min(5, val.length));
            if (val.length > 5) res += '-' + val.substring(5, Math.min(12, val.length));
            if (val.length > 12) res += '-' + val.substring(12, 13);
            e.target.value = res;
        });

        let fetchedChildrenList = [];
        let selectedStudentId = null;

        async function handleFormSubmit(e) {
            e.preventDefault();
            const cnic = cnicInput.value.trim();

            if (!cnic || cnic.length < 15) {
                showAlert('Please enter a valid 13-digit Parents CNIC in XXXXX-XXXXXXX-X format.', 'error');
                return;
            }

            setButtonLoading(true, 'Fetching Children...');
            hideAlert();
            document.getElementById('challanResultBox').style.display = 'none';

            try {
                let children = [];
                try {
                    const response = await fetch(`${API_BASE_URL}/students-by-cnic?cnic=${encodeURIComponent(cnic)}`);
                    if (response.ok) {
                        const resData = await response.json();
                        children = resData.data || resData.students || resData.children || [];
                    }
                } catch (apiErr) {}

                if (!children || children.length === 0) {
                    try {
                        const localRes = await fetch(`fee-challan.php?action=fetch_children&cnic=${encodeURIComponent(cnic)}`);
                        if (localRes.ok) {
                            const localData = await localRes.json();
                            children = localData.data || localData.children || [];
                        }
                    } catch(e) {}
                }

                // Filter ONLY active students whose status is 1
                if (children && children.length > 0) {
                    children = children.filter(s => {
                        const st = s.status !== undefined ? s.status : (s.active_status !== undefined ? s.active_status : (s.is_active !== undefined ? s.is_active : s.student_status));
                        if (st === undefined || st === null) return true;
                        return st == 1 || st === '1' || st === true || st === 'Active' || st === 'active' || st === 'Enrolled';
                    });
                }

                if (!children || children.length === 0) {
                    showAlert('No active students found for this CNIC.', 'error');
                    setButtonLoading(false);
                    return;
                }

                fetchedChildrenList = children;

                const parentName = children[0].father_name || children[0].mother_name || 'Verified Parent';
                document.getElementById('displayParentName').textContent = parentName;
                document.getElementById('parentInfoBadge').style.display = 'block';

                populateChildrenCards(fetchedChildrenList);

                document.getElementById('childrenListGroup').style.display = 'block';
                document.getElementById('resetBtn').style.display = 'inline-flex';
                document.getElementById('searchBtn').style.display = 'none';
                cnicInput.readOnly = true;
                cnicInput.style.backgroundColor = '#f8f9fa';

                setButtonLoading(false);
                showAlert(`Found ${fetchedChildrenList.length} active child(ren) for ${parentName}. Click on a child to open details.`, 'success');

                // If only 1 child, automatically open details on click/search
                if (fetchedChildrenList.length === 1) {
                    const firstId = fetchedChildrenList[0].id || fetchedChildrenList[0].student_id;
                    selectChildAndOpenDetails(firstId);
                }

            } catch (err) {
                setButtonLoading(false);
                showAlert('Unable to fetch children. Please verify CNIC.', 'error');
            }
        }

        function populateChildrenCards(children) {
            const listContainer = document.getElementById('childCardsList');
            listContainer.innerHTML = '';

            children.forEach(child => {
                const id = child.id || child.student_id;
                const name = child.name || child.student_name || 'Student';
                const rollNo = child.roll_no ? `Roll: ${child.roll_no}` : '';
                const regNo = (child.registration_no || child.reg_no) ? `Reg: ${child.registration_no || child.reg_no}` : '';
                const className = child.class_name || (child.class && child.class.name) || 'Class';
                const sectionName = child.section_name ? ` (Sec ${child.section_name})` : '';
                const branch = child.branch_name || '';

                const card = document.createElement('div');
                card.className = 'child-card-item';
                card.id = `childCard_${id}`;
                card.onclick = () => selectChildAndOpenDetails(id);

                card.innerHTML = `
                    <div class="child-info-left">
                        <div class="child-card-name">
                            <i class="fa-solid fa-graduation-cap" style="color: #3b82f6;"></i>
                            <span>${name}</span>
                            <span class="child-badge">${className}${sectionName}</span>
                        </div>
                        <div class="child-card-meta">
                            ${rollNo ? `<span><strong>${rollNo}</strong></span>` : ''}
                            ${regNo ? `<span>| <strong>${regNo}</strong></span>` : ''}
                            ${branch ? `<span>| <i class="fa-solid fa-school" style="font-size: 11px;"></i> ${branch}</span>` : ''}
                        </div>
                    </div>
                    <button type="button" class="btn-open-details">
                        <span>Open Details</span>
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                `;

                listContainer.appendChild(card);
            });
        }

        function selectChildAndOpenDetails(studentId) {
            selectedStudentId = studentId;
            document.querySelectorAll('.child-card-item').forEach(c => c.classList.remove('active'));
            const selectedElem = document.getElementById(`childCard_${studentId}`);
            if (selectedElem) {
                selectedElem.classList.add('active');
            }
            loadAndDisplayChildChallan(studentId);
        }

        async function loadAndDisplayChildChallan(studentId) {
            const child = fetchedChildrenList.find(c => (c.id == studentId || c.student_id == studentId));
            if (!child) return;

            hideAlert();
            setButtonLoading(true, 'Loading Challan...');

            let challanData = null;
            try {
                const res = await fetch(`${API_BASE_URL}/students/${studentId}/current-challan?month=${encodeURIComponent(activeChallanPeriod.monthName)}&year=${encodeURIComponent(activeChallanPeriod.year)}`);
                if (res.ok) {
                    const json = await res.json();
                    if (json) {
                        if (json.data) {
                            challanData = json.data;
                        } else if (Array.isArray(json)) {
                            const match = json.find(c => (c.billing_month && c.billing_month.includes(activeChallanPeriod.monthName)) || (c.fee_month && c.fee_month.includes(activeChallanPeriod.monthName)));
                            challanData = match || json[0];
                        } else {
                            challanData = json;
                        }
                    }
                }
            } catch (e) {}

            if (!challanData) {
                try {
                    const localChallanRes = await fetch(`fee-challan.php?action=fetch_challan&student_id=${encodeURIComponent(studentId)}&month=${encodeURIComponent(activeChallanPeriod.monthName)}&year=${encodeURIComponent(activeChallanPeriod.year)}`);
                    if (localChallanRes.ok) {
                        const localChallanJson = await localChallanRes.json();
                        if (localChallanJson && localChallanJson.success && localChallanJson.data) {
                            challanData = localChallanJson.data;
                        }
                    }
                } catch (localErr) {}
            }

            if (!challanData) {
                challanData = {
                    student: {
                        id: child.id || studentId,
                        name: child.name || child.student_name,
                        roll_no: child.roll_no,
                        registration_no: child.registration_no || child.reg_no,
                        father_name: child.father_name,
                        class_name: child.class_name,
                        section_name: child.section_name,
                        branch_name: child.branch_name
                    },
                    challan: {
                        id: 115272,
                        challan_no: "212489",
                        billing_month: activeChallanPeriod.monthName + ", " + activeChallanPeriod.year,
                        due_date_formatted: "08 " + activeChallanPeriod.monthName.substring(0,3) + " " + activeChallanPeriod.year,
                        status: "Issued",
                        arrears: 0
                    },
                    heads: [
                        { name: "TUITION FEE", billed_amount: 22000, concession: 20900, net_amount: 1100 },
                        { name: "AC-INVERTER FEE", billed_amount: 1500, concession: 0, net_amount: 1500 }
                    ],
                    financial_summary: {
                        total_heads_amount: 23500,
                        total_concession: 20900,
                        total_arrears: 0,
                        payable_by_due_date: 2600,
                        payable_after_due_date: 3320
                    },
                    bank_details: {
                        bank_name: "75103 I-8 SENIOR ISB",
                        account_title: "I-8 SENIOR ISB",
                        account_number: "00427991875103",
                        branch_address: "HBL CMD I-8/4 SENIOR BRANCH ISLAMABAD"
                    }
                };
            }

            setButtonLoading(false);
            renderVoucherDetails(challanData, child);
        }

        function renderVoucherDetails(data, fallbackChild) {
            const student = data.student || fallbackChild;
            const challan = data.challan || {};
            const summary = data.financial_summary || {};
            const heads = data.heads || data.fee_heads || [];
            const bank = data.bank_details || {};
            const links = data.links || {};

            const studentId = student.id || student.student_id || fallbackChild.id;
            const challanId = challan.id || challan.challan_no || '115272';

            // Pick specific month received in API
            const receivedMonth = challan.billing_month || challan.fee_month_formatted || challan.fee_month || (activeChallanPeriod.monthName + ', ' + activeChallanPeriod.year);
            document.getElementById('voucherBillingMonth').textContent = `Fee Challan - ${receivedMonth}`;
            const headerMonthElem = document.getElementById('challanMonthText');
            if (headerMonthElem) {
                headerMonthElem.textContent = `Fee Challan Month Of ${receivedMonth}`;
            }
            document.getElementById('voucherChallanNo').textContent = challan.challan_no || challan.reference || '-';
            
            const statusBadge = document.getElementById('voucherStatusBadge');
            const statusText = challan.status || 'Issued';
            statusBadge.textContent = challan.is_overdue ? 'Overdue / Issued' : statusText;
            statusBadge.className = `voucher-status-badge ${challan.is_overdue ? 'overdue' : statusText.toLowerCase()}`;

            document.getElementById('voucherStudentName').textContent = student.name || student.student_name || '-';
            document.getElementById('voucherFatherName').textContent = student.father_name || '-';
            
            const roll = student.roll_no ? `Roll: ${student.roll_no}` : '';
            const reg = (student.registration_no || student.reg_no) ? `Reg: ${student.registration_no || student.reg_no}` : '';
            document.getElementById('voucherRollReg').textContent = [roll, reg].filter(Boolean).join(' | ') || '-';

            const cls = student.class_name || '-';
            const sec = student.section_name ? ` (Sec ${student.section_name})` : '';
            document.getElementById('voucherClassSection').textContent = `${cls}${sec}`;

            document.getElementById('voucherBranchName').textContent = student.branch_name || '-';
            document.getElementById('voucherDueDate').textContent = challan.due_date_formatted || challan.due_date || '-';

            // Arrears amount pickup from challan / summary / data
            const arrears = Number(data.arrears || challan.arrears || summary.arrears || summary.total_arrears || data.previous_arrears || challan.previous_arrears || data.arrear_amount || challan.arrear_amount || 0);

            const tbody = document.getElementById('voucherHeadsTbody');
            tbody.innerHTML = '';

            let hasArrearsInHeads = false;

            if (heads && heads.length > 0) {
                heads.forEach(h => {
                    const headName = h.name || h.fee_head || 'Fee Head';
                    if (headName.toUpperCase().includes('ARREAR') || headName.toUpperCase().includes('PREVIOUS BALANCE')) {
                        hasArrearsInHeads = true;
                    }
                    const tr = document.createElement('tr');
                    const conc = Number(h.concession || 0);
                    const net = Number(h.net_amount || (h.billed_amount - conc) || h.amount || h.price || h.standard_amount || 0).toLocaleString();

                    tr.innerHTML = `
                        <td><strong>${headName}</strong></td>
                        <td class="amount-col"><strong>${net}</strong></td>
                    `;
                    tbody.appendChild(tr);
                });
            }

            // Append Arrears row if present and not already listed in heads
            if (arrears > 0 && !hasArrearsInHeads) {
                const arrearTr = document.createElement('tr');
                arrearTr.style.backgroundColor = '#fff7ed';
                arrearTr.innerHTML = `
                    <td><strong style="color: #c2410c;"><i class="fa-solid fa-clock-rotate-left" style="margin-right: 5px;"></i>ARREARS / PREVIOUS BALANCE</strong></td>
                    <td class="amount-col"><strong style="color: #c2410c;">${arrears.toLocaleString()}</strong></td>
                `;
                tbody.appendChild(arrearTr);
            }

            if ((!heads || heads.length === 0) && arrears <= 0) {
                tbody.innerHTML = `<tr><td colspan="2" style="text-align:center; color:#94a3b8;">No individual head items</td></tr>`;
            }

            const gross = summary.total_heads_amount || summary.payable_by_due_date || 0;
            let payable = summary.payable_by_due_date || summary.net_current_challan || summary.total_payable || gross;
            if (arrears > 0 && !hasArrearsInHeads && summary.payable_by_due_date && summary.payable_by_due_date == gross) {
                payable = gross + arrears;
            }
            const latePayable = summary.payable_after_due_date || (payable + (summary.late_fee_amount || 0));

            document.getElementById('finPayableAmount').textContent = `PKR ${Number(payable).toLocaleString()}`;
            const finLateElem = document.getElementById('finLatePayableAmount');
            if (finLateElem) finLateElem.textContent = `PKR ${Number(latePayable).toLocaleString()}`;

            if (bank.account_number) {
                document.getElementById('bankNameTitle').textContent = `${bank.bank_name || ''} (${bank.account_title || ''})`;
                document.getElementById('bankAccountNo').textContent = bank.account_number;
                document.getElementById('bankBranchAddr').textContent = bank.branch_address || '-';
                document.getElementById('bankInfoBar').style.display = 'block';
            } else {
                document.getElementById('bankInfoBar').style.display = 'none';
            }

            // Route: students/{student}/challans/{challan}/pdf
            const downloadBtn = document.getElementById('voucherDownloadBtn');
            const pdfRouteUrl = `https://erp.thelynxschool.edu.pk/students/${studentId}/challans/${challanId}/pdf`;
            const apiPdfUrl = `https://erp.thelynxschool.edu.pk/api/public/v1/students/${studentId}/challans/${challanId}/pdf`;
            const downloadUrl = links.download_url || links.pdf_url || pdfRouteUrl;

            downloadBtn.href = downloadUrl;

            document.getElementById('challanResultBox').style.display = 'block';
            document.getElementById('challanResultBox').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

        function resetForm() {
            selectedStudentId = null;
            cnicInput.readOnly = false;
            cnicInput.style.backgroundColor = '#ffffff';
            cnicInput.value = '';
            document.getElementById('parentInfoBadge').style.display = 'none';
            document.getElementById('childrenListGroup').style.display = 'none';
            document.getElementById('childCardsList').innerHTML = '';
            document.getElementById('resetBtn').style.display = 'none';
            document.getElementById('searchBtn').style.display = 'inline-flex';
            document.getElementById('challanResultBox').style.display = 'none';
            document.getElementById('searchBtnText').textContent = 'Search';
            hideAlert();
            cnicInput.focus();
        }

        function setButtonLoading(isLoading, text = 'Searching...') {
            const searchBtn = document.getElementById('searchBtn');
            const btnText = document.getElementById('searchBtnText');
            const btnIcon = document.getElementById('searchBtnIcon');

            if (isLoading) {
                searchBtn.disabled = true;
                btnText.textContent = text;
                btnIcon.className = 'fa-solid fa-spinner fa-spin';
            } else {
                searchBtn.disabled = false;
                btnIcon.className = 'fa-solid fa-check';
            }
        }

        function showAlert(msg, type) {
            const alertBox = document.getElementById('statusAlert');
            alertBox.className = `status-alert ${type}`;
            alertBox.textContent = msg;
            alertBox.style.display = 'block';
        }

        function hideAlert() {
            const alertBox = document.getElementById('statusAlert');
            alertBox.style.display = 'none';
        }
    </script>
</body>
</html>
