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

        /* Frosted light educational backdrop */
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

        /* Main Form Card */
        .challan-card {
            background: #ffffff;
            width: 100%;
            border-radius: 8px;
            box-shadow: 0 6px 28px rgba(0, 0, 0, 0.1), 0 1px 4px rgba(0, 0, 0, 0.05);
            padding: 36px 42px 34px 42px;
            transition: all 0.3s ease;
        }

        /* Logo Area */
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

        /* Subtitle / Month Notice */
        .challan-month {
            color: #ee6f7d;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 20px;
            letter-spacing: 0.1px;
            text-align: left;
        }

        /* Parent Info Badge after search */
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

        /* Form Controls */
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

        /* Dropdown selection styling */
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

        /* Action Row */
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

        /* Status Alert */
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

        /* ------------------------------------------------------------- */
        /* DETAILED CHALLAN VOUCHER PRESENTATION                         */
        /* ------------------------------------------------------------- */
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

        /* Student Metadata Grid */
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

        /* Fee Heads Breakdown Table */
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

        .heads-table tr.total-row td {
            font-weight: 700;
            border-top: 2px solid #e2e8f0;
            background: #f8fafc;
        }

        /* Financial Summary Box */
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

        /* Bank Info Bar */
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

        /* Action Buttons - Only Download Button */
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

        /* Footer */
        .footer-text {
            margin-top: 24px;
            font-size: 13.5px;
            font-weight: 600;
            color: #ffffff;
            text-align: center;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.7);
            letter-spacing: 0.1px;
        }

        /* Responsive */
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
    
        .main-wrapper { max-width: 760px; }
        .cnic-action-row { display:grid; grid-template-columns:1fr auto auto; align-items:stretch; gap:8px; }
        .cnic-action-row .input-control { height:44px; }
        .cnic-action-row .btn-reset,.cnic-action-row .btn-search { align-items:center; gap:6px; margin:0; min-height:44px; padding:0 14px; } .cnic-action-row .btn-search{display:inline-flex}
        .child-card-item { cursor:default; display:block; padding:16px 18px; }
        .child-actions { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:8px; margin-top:14px; }
        .child-action-btn { border:1px solid #2563eb; background:#fff; color:#1d4ed8; padding:8px 10px; border-radius:5px; font:700 11px inherit; cursor:pointer; white-space:nowrap; }
        .child-action-btn:hover { background:#eff6ff; }
        .child-action-btn.deposit { border-color:#16a34a; color:#15803d; }
        .portal-modal { display:none; position:fixed; inset:0; z-index:10000; padding:20px; background:rgba(15,23,42,.58); align-items:center; justify-content:center; }
        .portal-modal.open { display:flex; }
        .portal-modal-card { width:min(520px,100%); max-height:90vh; overflow:auto; background:#fff; border-radius:10px; box-shadow:0 25px 70px rgba(0,0,0,.3); }
        .portal-modal-lg { width:min(820px,100%); }
        .portal-modal-header { display:flex; align-items:center; justify-content:space-between; padding:16px 20px; border-bottom:1px solid #e2e8f0; }
        .portal-modal-header h3 { font-size:17px; color:#0f172a; }
        .portal-modal-header button { border:0; background:transparent; font-size:28px; cursor:pointer; color:#64748b; }
        .portal-modal-body { padding:20px; }
        .statement-group { border:1px solid #dbeafe; border-radius:8px; overflow:hidden; margin-bottom:14px; }
        .statement-challan { display:flex; justify-content:space-between; gap:12px; padding:12px 14px; color:#fff; background:#172554; font-weight:800; }
        .statement-head { padding:10px 14px; background:#f8fafc; font-size:13px; color:#334155; display:flex; justify-content:space-between; gap:15px; }
        .entry-type{display:inline-block;padding:3px 7px;border-radius:4px;font-size:10px;letter-spacing:.4px;margin-right:6px}.challan-type{background:#dbeafe;color:#1e40af}.receipt-type{background:#dcfce7;color:#166534}
        .receipt-line { display:grid; grid-template-columns:1fr auto auto; gap:15px; padding:10px 14px; border-top:1px solid #e2e8f0; font-size:13px; }
        .empty-receipt { padding:10px 14px; color:#94a3b8; font-size:13px; }
        .file-control { height:auto; padding:9px; }
        @media(max-width:700px){
        .student-repeater-row{grid-template-columns:1fr !important;} .challan-card{padding:24px 18px}.cnic-action-row{grid-template-columns:1fr auto auto}.child-actions{grid-template-columns:1fr}.receipt-line{grid-template-columns:1fr}.statement-head{display:block}.portal-modal{padding:8px} }
    </style>
</head>
<body>

    <div class="main-wrapper">
        <div class="challan-card">
            
            <!-- The Lynx School Logo -->
            <a href="index.html" style="text-decoration: none; color: inherit; display: block;">
                <div class="logo-container">
                    <img src="assets/img/lnxlogo-removebg-preview(1).png" alt="The Lynx School Crest" class="logo-img">
                    <div class="logo-text-cursive">The Lynx School</div>
                </div>
            </a>

            <!-- Dynamic Fee Challan Month (Auto Next Month after 25th) -->
            <div class="challan-month" id="challanMonthText">
                Fee Challan Month Of September 2026
            </div>

            <!-- Form -->
            <form id="challanForm" onsubmit="handleFormSubmit(event)">
                
                <!-- Parents CNIC Field -->
                <div class="form-group" id="cnicGroup">
                    <label for="cnic">Parents CNIC No. Format(XXXXX-XXXXXXX-X)</label>
                    <div class="cnic-action-row">
                        <input type="text" id="cnic" name="cnic" class="input-control" placeholder="XXXXX-XXXXXXX-X" maxlength="15" autocomplete="off" required>
                        <button type="button" class="btn-reset" id="resetBtn" onclick="resetForm()"><i class="fa-solid fa-rotate-left"></i><span>Change</span></button>
                        <button type="submit" class="btn-search" id="searchBtn"><span id="searchBtnText">Search</span><i class="fa-solid fa-magnifying-glass" id="searchBtnIcon"></i></button>
                    </div>
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

                <div id="statusAlert" class="status-alert"></div></form>
                        <div class="portal-modal" id="updateRequestModal" aria-hidden="true">
                <div class="portal-modal-card portal-modal-lg">
                    <div class="portal-modal-header">
                        <h3 style="display:flex;align-items:center;gap:8px;"><i class="fa-solid fa-user-pen" style="color:#2563eb"></i> Request to Update Data</h3>
                        <button type="button" onclick="closePortalModal('updateRequestModal')">&times;</button>
                    </div>
                    <form class="portal-modal-body" id="updateRequestForm" onsubmit="submitParentUpdateRequest(event)">
                        <div id="updateRequestAlert" class="status-alert" style="display:none;margin-bottom:16px;"></div>

                        <!-- Parent Info -->
                        <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;padding:16px;margin-bottom:18px;">
                            <h4 style="font-size:13.5px;color:#1e293b;font-weight:800;margin-bottom:12px;display:flex;align-items:center;gap:6px;">
                                <i class="fa-solid fa-id-card" style="color:#2563eb"></i> Parent / Guardian Information
                            </h4>
                            <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));gap:12px;">
                                <div class="form-group" style="margin-bottom:0;">
                                    <label for="reqParentName">Parent Name <span style="color:#dc2626;">*</span></label>
                                    <input type="text" id="reqParentName" class="input-control" placeholder="e.g. Muhammad Ali" required>
                                </div>
                                <div class="form-group" style="margin-bottom:0;">
                                    <label for="reqPhoneNo">Phone No <span style="color:#dc2626;">*</span></label>
                                    <input type="tel" id="reqPhoneNo" class="input-control" placeholder="e.g. 03001234567 or +923001234567" maxlength="14" required autocomplete="tel">
                                </div>
                                <div class="form-group" style="margin-bottom:0;">
                                    <label for="reqCnic">Parents CNIC <span style="color:#dc2626;">*</span></label>
                                    <input type="text" id="reqCnic" class="input-control" placeholder="XXXXX-XXXXXXX-X" maxlength="15" required>
                                </div>
                            </div>
                        </div>

                        <!-- Student Details Repeater -->
                        <div style="background:#ffffff;border:1.5px solid #e2e8f0;border-radius:8px;padding:16px;margin-bottom:18px;">
                            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;flex-wrap:wrap;gap:8px;">
                                <h4 style="font-size:13.5px;color:#1e293b;font-weight:800;margin-bottom:0;display:flex;align-items:center;gap:6px;">
                                    <i class="fa-solid fa-graduation-cap" style="color:#2563eb"></i> Student Details
                                </h4>
                                <button type="button" class="child-action-btn" onclick="addStudentRepeaterRow()" style="background:#eff6ff;border-color:#3b82f6;color:#1d4ed8;display:inline-flex;align-items:center;gap:5px;">
                                    <i class="fa-solid fa-plus"></i> Add Child
                                </button>
                            </div>
                            <div id="studentRepeaterContainer" style="display:flex;flex-direction:column;gap:12px;">
                                <!-- Dynamically generated repeater rows -->
                            </div>
                        </div>

                        <!-- CNIC Pictures Upload -->
                        <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;padding:16px;margin-bottom:20px;">
                            <h4 style="font-size:13.5px;color:#1e293b;font-weight:800;margin-bottom:12px;display:flex;align-items:center;gap:6px;">
                                <i class="fa-solid fa-camera" style="color:#2563eb"></i> CNIC Pictures Upload (Front & Back)
                            </h4>
                            <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(240px, 1fr));gap:14px;">
                                <div class="form-group" style="margin-bottom:0;">
                                    <label for="reqCnicFront">CNIC Front Picture <span style="color:#dc2626;">*</span> <small style="font-weight:normal;color:#64748b;">(Max 1MB)</small></label>
                                    <input type="file" id="reqCnicFront" class="input-control file-control" accept="image/*,.pdf" required onchange="previewFileThumb(this, 'frontThumb')">
                                    <div id="frontThumb" style="margin-top:6px;display:none;"></div>
                                </div>
                                <div class="form-group" style="margin-bottom:0;">
                                    <label for="reqCnicBack">CNIC Back Picture <span style="color:#dc2626;">*</span> <small style="font-weight:normal;color:#64748b;">(Max 1MB)</small></label>
                                    <input type="file" id="reqCnicBack" class="input-control file-control" accept="image/*,.pdf" required onchange="previewFileThumb(this, 'backThumb')">
                                    <div id="backThumb" style="margin-top:6px;display:none;"></div>
                                </div>
                            </div>
                        </div>

                        <div style="display:flex;justify-content:flex-end;gap:10px;align-items:center;">
                            <button type="button" class="btn-reset" style="display:inline-flex;" onclick="closePortalModal('updateRequestModal')">Cancel</button>
                            <button type="submit" class="btn-search" id="reqSubmitBtn" style="background-color:#2563eb;display:inline-flex;gap:7px;">
                                <span id="reqSubmitBtnText">Submit Request</span>
                                <i class="fa-solid fa-paper-plane" id="reqSubmitBtnIcon"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="portal-modal" id="statementModal" aria-hidden="true">
                <div class="portal-modal-card portal-modal-lg">
                    <div class="portal-modal-header"><h3>Last 3 Months Fee Statement</h3><button type="button" onclick="closePortalModal('statementModal')">&times;</button></div>
                    <div class="portal-modal-body" id="statementContent"></div>
                </div>
            </div>
            <div class="portal-modal" id="depositModal" aria-hidden="true">
                <div class="portal-modal-card">
                    <div class="portal-modal-header"><h3>Attach Deposit Slip</h3><button type="button" onclick="closePortalModal('depositModal')">&times;</button></div>
                    <form class="portal-modal-body" id="depositSlipForm" onsubmit="submitDepositSlip(event)">
                        <input type="hidden" id="depositStudentId"><input type="hidden" id="depositChallanId">
                        <div class="form-group"><label>Challan No</label><input class="input-control" id="depositChallanNo" disabled></div>
                        <div class="form-group"><label>Deposit Slip (JPG, PNG or PDF; max 5 MB)</label><input class="input-control file-control" type="file" id="depositSlipFile" accept=".jpg,.jpeg,.png,.pdf" required></div>
                        <button type="submit" class="btn-search" id="depositSubmitBtn"><span>Upload Slip</span><i class="fa-solid fa-upload"></i></button>
                    </form>
                </div>
            </div>

        </div>

        <!-- Footer -->
        <div class="footer-text">
            Copyright &copy; <span id="currentYear">2026</span>, The Lynx School.
        </div>
    </div>
    <script>
        const isLocal = ['localhost', '127.0.0.1'].includes(window.location.hostname);
        const ERP_BASE_URL = isLocal ? 'http://localhost/lynxupdate' : 'https://erp.thelynxschool.edu.pk';
        const API_BASE_URL = `${ERP_BASE_URL}/api/public/v1`;
        const cnicInput = document.getElementById('cnic');
        let fetchedChildrenList = [];
        let challanCache = {};

        document.getElementById('currentYear').textContent = new Date().getFullYear();
        updateChallanMonthHeader();
        cnicInput.addEventListener('input', function (event) {
            let value = event.target.value.replace(/\D/g, '').slice(0, 13);
            event.target.value = value.slice(0,5) + (value.length > 5 ? '-' + value.slice(5,12) : '') + (value.length > 12 ? '-' + value.slice(12) : '');
        });

        function updateChallanMonthHeader() {
            const date = new Date();
            if (date.getDate() > 25) date.setMonth(date.getMonth() + 1);
            document.getElementById('challanMonthText').textContent = `Fee Challan Month Of ${date.toLocaleString('en-US',{month:'long'})} ${date.getFullYear()}`;
        }

        async function handleFormSubmit(event) {
            event.preventDefault();
            const cnic = cnicInput.value.trim();
            if (cnic.replace(/\D/g,'').length !== 13) return showAlert('Please enter a valid 13-digit Parents CNIC.', 'error');
            setButtonLoading(true, 'Fetching Children...'); hideAlert();
            try {
                const response = await fetch(`${API_BASE_URL}/students-by-cnic?cnic=${encodeURIComponent(cnic)}`, {headers:{Accept:'application/json'}});
                const payload = await response.json();
                if (response.status === 404) { showContactAlert(); return; }
                if (!response.ok) throw new Error(payload.message || 'Unable to search students.');
                fetchedChildrenList = (payload.data || []).filter(student => student.active_status == 1 || String(student.student_status).toLowerCase() === 'active');
                if (!fetchedChildrenList.length) { showContactAlert(); return; }
                const first = fetchedChildrenList[0];
                const parents = [first.father_name, first.mother_name].map(v => String(v || '').trim()).filter((v,i,a) => v && a.indexOf(v) === i);
                const parentName = (parents.join(' / ') || 'Verified Parent').toUpperCase();
                document.getElementById('displayParentName').textContent = parentName;
                document.getElementById('parentInfoBadge').style.display = 'block';
                populateChildrenCards(fetchedChildrenList);
                document.getElementById('childrenListGroup').style.display = 'block';
                document.getElementById('resetBtn').style.display = 'inline-flex';
                document.getElementById('searchBtn').style.display = 'none';
                cnicInput.readOnly = true; cnicInput.style.backgroundColor = '#f8f9fa';
                showAlert(`Found ${fetchedChildrenList.length} active child(ren) for ${parentName}.`, 'success');
            } catch (error) { showAlert(error.message || 'Unable to fetch children.', 'error'); }
            finally { setButtonLoading(false); }
        }

        function populateChildrenCards(children) {
            const list = document.getElementById('childCardsList'); list.innerHTML = '';
            children.forEach(child => {
                const id = child.id || child.student_id || child.child_id;
                const card = document.createElement('div'); card.className = 'child-card-item';
                card.innerHTML = `<div class="child-info-left"><div class="child-card-name"><i class="fa-solid fa-graduation-cap" style="color:#3b82f6"></i><span>${escapeHtml(child.student_name || child.name || 'Student')}</span><span class="child-badge">${escapeHtml(child.class_name || 'Class')}${child.section_name ? ' (Sec '+escapeHtml(child.section_name)+')':''}</span></div><div class="child-card-meta">${child.roll_no ? '<span><strong>Roll: '+escapeHtml(child.roll_no)+'</strong></span>':''}${child.branch_name ? '<span> | <i class="fa-solid fa-school"></i> '+escapeHtml(child.branch_name)+'</span>':''}</div></div><div class="child-actions"><button type="button" class="child-action-btn" onclick="viewChallan(${Number(id)})"><i class="fa-solid fa-file-invoice"></i> View Challan</button><button type="button" class="child-action-btn" onclick="viewStatement(${Number(id)})"><i class="fa-solid fa-list"></i> View Statement</button><button type="button" class="child-action-btn deposit" onclick="openDepositSlip(${Number(id)})"><i class="fa-solid fa-paperclip"></i> Attach Deposit Slip</button></div>`;
                list.appendChild(card);
            });
        }

        function childById(id){ return fetchedChildrenList.find(child => Number(child.id || child.student_id || child.child_id) === Number(id)); }
        async function currentChallan(id) {
            if (challanCache[id]) return challanCache[id];
            const response = await fetch(`${API_BASE_URL}/students/${id}/current-challan`, {headers:{Accept:'application/json'}});
            const payload = await response.json();
            if (!response.ok || !payload.data) throw new Error(payload.message || 'No challan found for this student.');
            return (challanCache[id] = payload.data);
        }
        async function viewChallan(id) {
            try { const data = await currentChallan(id); sessionStorage.setItem('feeChallanCnic', cnicInput.value); window.location.href = `challan-view.html?key=${encodeURIComponent(data.challan.view_token)}`; }
            catch(error){ showAlert(error.message, 'error'); }
        }
        async function viewStatement(id) {
            const child = childById(id); openPortalModal('statementModal');
            const box = document.getElementById('statementContent'); box.innerHTML = '<div class="empty-receipt">Loading statement...</div>';
            try {
                const response = await fetch(`${API_BASE_URL}/students/${id}/fee-statement`, {headers:{Accept:'application/json', Authorization:`Bearer ${child.access_token || ''}`}});
                const payload = await response.json(); if(!response.ok) throw new Error(payload.message || 'Unable to load statement.');
                box.innerHTML = payload.data.length ? payload.data.map(challan => `<div class="statement-group"><div class="statement-challan"><span><b class="entry-type challan-type">CHALLAN</b> #${escapeHtml(challan.challan_no)}</span><span>${escapeHtml(challan.fee_month)}</span></div><div class="statement-head"><span><strong>Head:</strong> ${escapeHtml((challan.heads || []).join(', ') || '-')}</span><span><strong>Challan Amount:</strong> PKR ${Number(challan.challan_amount || 0).toLocaleString()}</span></div>${challan.receipts.length ? (() => { const receiptTotal = challan.receipts.reduce((sum, receipt) => sum + Number(receipt.paid_amount || 0), 0); const receiptDates = [...new Set(challan.receipts.map(receipt => receipt.paid_date).filter(Boolean))].join(', '); return `<div class="receipt-line"><span><b class="entry-type receipt-type">RECEIPT</b></span><span><strong>Cumulative Paid:</strong> PKR ${receiptTotal.toLocaleString()}</span><span><strong>Receipt Date:</strong> ${escapeHtml(receiptDates || '-')}</span></div>`; })() : '<div class="empty-receipt">No receipt posted against this challan.</div>'}</div>`).join('') : '<div class="empty-receipt">No challans found in the last three fee months.</div>';
            } catch(error){ box.innerHTML = `<div class="status-alert error" style="display:block">${escapeHtml(error.message)}</div>`; }
        }
        async function openDepositSlip(id) {
            try { const data=await currentChallan(id); document.getElementById('depositStudentId').value=id; document.getElementById('depositChallanId').value=data.challan.id; document.getElementById('depositChallanNo').value=data.challan.challan_no; document.getElementById('depositSlipFile').value=''; openPortalModal('depositModal'); }
            catch(error){ showAlert(error.message, 'error'); }
        }
        async function submitDepositSlip(event) {
            event.preventDefault(); const id=document.getElementById('depositStudentId').value; const child=childById(id); const file=document.getElementById('depositSlipFile').files[0];
            if(!file) return; const button=document.getElementById('depositSubmitBtn'); button.disabled=true;
            const data=new FormData(); data.append('challan_id',document.getElementById('depositChallanId').value); data.append('slip',file);
            try { const response=await fetch(`${API_BASE_URL}/students/${id}/deposit-slips`,{method:'POST',body:data,headers:{Accept:'application/json',Authorization:'Bearer ' + (child.access_token || '')}}); const payload=await response.json(); if(!response.ok) throw new Error(payload.message || Object.values(payload.errors || {}).flat().join(' ')); closePortalModal('depositModal'); showAlert(payload.message,'success'); }
            catch(error){ showAlert(error.message || 'Upload failed.','error'); } finally { button.disabled=false; }
        }
        function openPortalModal(id){ const modal=document.getElementById(id); modal.classList.add('open'); modal.setAttribute('aria-hidden','false'); }
        function closePortalModal(id){ const modal=document.getElementById(id); modal.classList.remove('open'); modal.setAttribute('aria-hidden','true'); }
        function resetForm(){ sessionStorage.removeItem('feeChallanCnic'); fetchedChildrenList=[]; challanCache={}; cnicInput.readOnly=false; cnicInput.style.backgroundColor='#fff'; cnicInput.value=''; document.getElementById('parentInfoBadge').style.display='none'; document.getElementById('childrenListGroup').style.display='none'; document.getElementById('childCardsList').innerHTML=''; document.getElementById('resetBtn').style.display='none'; document.getElementById('searchBtn').style.display='inline-flex'; hideAlert(); cnicInput.focus(); }
        function setButtonLoading(loading,text='Searching...'){ const button=document.getElementById('searchBtn'); button.disabled=loading; document.getElementById('searchBtnText').textContent=loading?text:'Search'; document.getElementById('searchBtnIcon').className=loading?'fa-solid fa-spinner fa-spin':'fa-solid fa-check'; }
        function showAlert(message,type){ const box=document.getElementById('statusAlert'); box.className=`status-alert ${type}`; box.textContent=message; box.style.display='block'; }
        function showContactAlert(){
            const box=document.getElementById('statusAlert');
            box.className='status-alert error';
            box.innerHTML=`
                <div style="font-weight:800;font-size:14px;margin-bottom:6px;"><i class="fa-solid fa-circle-exclamation me-1"></i> No active student record was found for this CNIC.</div>
                <div style="font-size:13px;line-height:1.5;margin-bottom:12px;color:#475569;">Please contact your child's branch (contact details) or complete the below-provided Form to have your record updated within 24 hours.</div>
                <div style="display:flex;gap:10px;flex-wrap:wrap;align-items:center;">
                    <a href="contacts.html" class="child-action-btn" style="text-decoration:none;display:inline-flex;align-items:center;gap:6px;padding:8px 14px;background:#fff;border-color:#cbd5e1;color:#334155;">
                        <i class="fa-solid fa-phone"></i> View Branch Contacts
                    </a>
                    <button type="button" class="btn-search" onclick="openUpdateRequestModal()" style="padding:8px 18px;font-size:13px;background-color:#2563eb;display:inline-flex;gap:6px;">
                        <i class="fa-solid fa-user-pen"></i> Request to Update data
                    </button>
                </div>
            `;
            box.style.display='block';
        }        function hideAlert(){ document.getElementById('statusAlert').style.display='none'; }
        function escapeHtml(value){ const node=document.createElement('div'); node.textContent=String(value ?? ''); return node.innerHTML; }
        
        // ── Data Update Request Functions ────────────────────────────────
        let activeBranchesList = [];

        async function fetchActiveBranches() {
            if (activeBranchesList.length > 0) return activeBranchesList;
            try {
                const res = await fetch(`${API_BASE_URL}/active-branches`, { headers: { Accept: 'application/json' } });
                const json = await res.json();
                if (json.success && Array.isArray(json.data)) {
                    activeBranchesList = json.data;
                }
            } catch (e) {
                console.error('Failed to fetch active branches:', e);
            }
            return activeBranchesList;
        }

        function buildBranchOptionsHtml(selectedId = '') {
            let html = '<option value="">Select Branch...</option>';
            activeBranchesList.forEach(b => {
                const sel = String(b.id) === String(selectedId) ? 'selected' : '';
                html += `<option value="${escapeHtml(b.id)}" ${sel}>${escapeHtml(b.name)}</option>`;
            });
            return html;
        }

        async function openUpdateRequestModal() {
            const currentCnic = (cnicInput ? cnicInput.value.trim() : '');
            const reqCnicEl = document.getElementById('reqCnic');
            if (reqCnicEl) {
                reqCnicEl.value = currentCnic;
            }
            const alertEl = document.getElementById('updateRequestAlert');
            if (alertEl) {
                alertEl.style.display = 'none';
            }

            await fetchActiveBranches();

            const container = document.getElementById('studentRepeaterContainer');
            if (container && container.children.length === 0) {
                addStudentRepeaterRow();
            }

            openPortalModal('updateRequestModal');
        }

        function addStudentRepeaterRow(data = {}) {
            const container = document.getElementById('studentRepeaterContainer');
            if (!container) return;

            const row = document.createElement('div');
            row.className = 'student-repeater-row';
            row.style.cssText = 'background:#f8fafc;border:1px solid #e2e8f0;border-radius:6px;padding:12px;position:relative;display:grid;grid-template-columns:1.2fr 1fr 1.3fr auto;gap:10px;align-items:end;';

            row.innerHTML = `
                <div class="form-group" style="margin-bottom:0;">
                    <label style="font-size:12px;font-weight:700;">Active Branch <span style="color:#dc2626;">*</span></label>
                    <select class="input-control student-branch" required>
                        ${buildBranchOptionsHtml(data.branch_id || '')}
                    </select>
                </div>
                <div class="form-group" style="margin-bottom:0;">
                    <label style="font-size:12px;font-weight:700;">Student Roll No.</label>
                    <input type="text" class="input-control student-roll" placeholder="e.g. 10243" value="${escapeHtml(data.roll_no || '')}">
                </div>
                <div class="form-group" style="margin-bottom:0;">
                    <label style="font-size:12px;font-weight:700;">Student Name <span style="color:#dc2626;">*</span></label>
                    <input type="text" class="input-control student-name" placeholder="Full Student Name" value="${escapeHtml(data.student_name || '')}" required>
                </div>
                <div>
                    <button type="button" class="child-action-btn remove-row-btn" onclick="removeStudentRepeaterRow(this)" style="background:#fee2e2;border-color:#fca5a5;color:#dc2626;padding:9px 12px;margin:0;" title="Remove this child">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
            `;

            container.appendChild(row);
            updateRepeaterRemoveButtons();
        }

        function removeStudentRepeaterRow(btn) {
            const container = document.getElementById('studentRepeaterContainer');
            if (!container || container.children.length <= 1) return;
            const row = btn.closest('.student-repeater-row');
            if (row) row.remove();
            updateRepeaterRemoveButtons();
        }

        function updateRepeaterRemoveButtons() {
            const container = document.getElementById('studentRepeaterContainer');
            if (!container) return;
            const rows = container.querySelectorAll('.student-repeater-row');
            rows.forEach((r, idx) => {
                const btn = r.querySelector('.remove-row-btn');
                if (btn) {
                    btn.style.display = rows.length > 1 ? 'inline-block' : 'none';
                }
            });
        }

        function previewFileThumb(input, targetId) {
            const target = document.getElementById(targetId);
            if (!target) return;
            const file = input.files[0];
            if (!file) {
                target.innerHTML = '';
                target.style.display = 'none';
                return;
            }

            const MAX_SIZE = 1 * 1024 * 1024; // 1 MB
            if (file.size > MAX_SIZE) {
                const sizeInMb = (file.size / (1024 * 1024)).toFixed(2);
                alert(`File size (${sizeInMb} MB) exceeds the 1 MB limit. Please upload an image under 1 MB.`);
                input.value = '';
                target.innerHTML = '';
                target.style.display = 'none';
                return;
            }

            if (file.type && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    target.innerHTML = `<img src="${e.target.result}" style="max-height:80px;border-radius:4px;border:1px solid #cbd5e1;margin-top:6px;">`;
                    target.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                target.innerHTML = `<span class="badge" style="background:#e0f2fe;color:#0369a1;padding:4px 8px;display:inline-block;margin-top:6px;"><i class="fa-solid fa-file-pdf"></i> ${escapeHtml(file.name)}</span>`;
                target.style.display = 'block';
            }
        }

        async function submitParentUpdateRequest(event) {
            event.preventDefault();
            const alertBox = document.getElementById('updateRequestAlert');
            alertBox.style.display = 'none';

            const parentName = document.getElementById('reqParentName').value.trim();
            const phoneNo = document.getElementById('reqPhoneNo').value.trim();
            const phoneDigits = phoneNo.replace(/\D/g, '');

            if (phoneDigits.length < 10 || phoneDigits.length > 13) {
                alertBox.className = 'status-alert error';
                alertBox.textContent = 'Please enter a valid phone number (11 to 13 digits, e.g. 03001234567 or +923001234567).';
                alertBox.style.display = 'block';
                return;
            }
            const cnic = document.getElementById('reqCnic').value.trim();
            const frontFile = document.getElementById('reqCnicFront').files[0];
            const backFile = document.getElementById('reqCnicBack').files[0];

            if (cnic.replace(/\D/g, '').length !== 13) {
                alertBox.className = 'status-alert error';
                alertBox.textContent = 'Please enter a valid 13-digit CNIC number.';
                alertBox.style.display = 'block';
                return;
            }

            const MAX_IMAGE_SIZE = 1 * 1024 * 1024; // 1 MB
            if (frontFile && frontFile.size > MAX_IMAGE_SIZE) {
                alertBox.className = 'status-alert error';
                alertBox.textContent = 'CNIC Front picture exceeds 1 MB limit. Please upload an image under 1 MB.';
                alertBox.style.display = 'block';
                return;
            }
            if (backFile && backFile.size > MAX_IMAGE_SIZE) {
                alertBox.className = 'status-alert error';
                alertBox.textContent = 'CNIC Back picture exceeds 1 MB limit. Please upload an image under 1 MB.';
                alertBox.style.display = 'block';
                return;
            }

            const rows = document.querySelectorAll('#studentRepeaterContainer .student-repeater-row');
            const students = [];
            for (let i = 0; i < rows.length; i++) {
                const branchId = rows[i].querySelector('.student-branch').value;
                const rollNo = rows[i].querySelector('.student-roll').value.trim();
                const studentName = rows[i].querySelector('.student-name').value.trim();

                if (!branchId) {
                    alertBox.className = 'status-alert error';
                    alertBox.textContent = `Please select an active branch for student #${i + 1}.`;
                    alertBox.style.display = 'block';
                    return;
                }
                if (!studentName) {
                    alertBox.className = 'status-alert error';
                    alertBox.textContent = `Please enter student name for student #${i + 1}.`;
                    alertBox.style.display = 'block';
                    return;
                }

                students.push({
                    branch_id: branchId,
                    roll_no: rollNo,
                    student_name: studentName
                });
            }

            if (students.length === 0) {
                alertBox.className = 'status-alert error';
                alertBox.textContent = 'Please add at least one student record.';
                alertBox.style.display = 'block';
                return;
            }

            if (!frontFile || !backFile) {
                alertBox.className = 'status-alert error';
                alertBox.textContent = 'Both CNIC Front and CNIC Back pictures are required.';
                alertBox.style.display = 'block';
                return;
            }

            const submitBtn = document.getElementById('reqSubmitBtn');
            const submitText = document.getElementById('reqSubmitBtnText');
            const submitIcon = document.getElementById('reqSubmitBtnIcon');
            submitBtn.disabled = true;
            submitText.textContent = 'Submitting Request...';
            submitIcon.className = 'fa-solid fa-spinner fa-spin';

            const formData = new FormData();
            formData.append('parent_name', parentName);
            formData.append('phone_no', phoneNo);
            formData.append('cnic', cnic);
            formData.append('cnic_front', frontFile);
            formData.append('cnic_back', backFile);
            formData.append('students', JSON.stringify(students));

            try {
                const res = await fetch(`${API_BASE_URL}/parent-update-requests`, {
                    method: 'POST',
                    headers: {
                        Accept: 'application/json'
                    },
                    body: formData
                });

                const payload = await res.json();
                if (!res.ok) {
                    throw new Error(payload.message || Object.values(payload.errors || {}).flat().join(' '));
                }

                alertBox.className = 'status-alert success';
                alertBox.innerHTML = `<i class="fa-solid fa-circle-check"></i> ${escapeHtml(payload.message || 'Update request submitted successfully!')}`;
                alertBox.style.display = 'block';

                document.getElementById('updateRequestForm').reset();
                const fThumb = document.getElementById('frontThumb');
                if (fThumb) { fThumb.innerHTML = ''; fThumb.style.display = 'none'; }
                const bThumb = document.getElementById('backThumb');
                if (bThumb) { bThumb.innerHTML = ''; bThumb.style.display = 'none'; }
                document.getElementById('studentRepeaterContainer').innerHTML = '';
                addStudentRepeaterRow();

                setTimeout(() => {
                    closePortalModal('updateRequestModal');
                    showAlert('Your data update request has been submitted successfully. The respective branch will review your request.', 'success');
                }, 2000);
            } catch (err) {
                alertBox.className = 'status-alert error';
                alertBox.textContent = err.message || 'Submission failed. Please check your connection and try again.';
                alertBox.style.display = 'block';
            } finally {
                submitBtn.disabled = false;
                submitText.textContent = 'Submit Request';
                submitIcon.className = 'fa-solid fa-paper-plane';
            }
        }

        // Auto-format CNIC in update request modal
        document.addEventListener('DOMContentLoaded', function() {
            const reqPhoneInput = document.getElementById('reqPhoneNo');
            if (reqPhoneInput) {
                reqPhoneInput.addEventListener('input', function(e) {
                    let val = e.target.value;
                    let hasPlus = val.startsWith('+');
                    let digits = val.replace(/\D/g, '').slice(0, 13);
                    e.target.value = (hasPlus ? '+' : '') + digits;
                });
            }

            const reqCnicInput = document.getElementById('reqCnic');
            if (reqCnicInput) {
                reqCnicInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '').slice(0, 13);
                    e.target.value = value.slice(0,5) + (value.length > 5 ? '-' + value.slice(5,12) : '') + (value.length > 12 ? '-' + value.slice(12) : '');
                });
            }
        });

        window.addEventListener('pageshow', function () {
            const savedCnic = sessionStorage.getItem('feeChallanCnic');
            if (savedCnic && !cnicInput.value && !fetchedChildrenList.length) {
                cnicInput.value = savedCnic;
                document.getElementById('challanForm').requestSubmit();
            }
        });
    </script>
</body>
</html>
