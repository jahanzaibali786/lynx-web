<?php
include 'connection.php';
header('Content-Type: application/json');

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'getEvents':
        getEvents($conn);
        break;

    case 'getNews':
        //dd("ALA");
        getNews($conn);
        break;

    case 'getNewsDetail':
        $id = intval($_GET['id'] ?? 0);
        getNewsDetail($conn, $id);
        break;

    case 'getEventDetail':
        $id = intval($_GET['id'] ?? 0);
        getEventDetail($conn, $id);
        break;

    case 'getGalleries':
        getGalleries($conn);
        break;

    case 'getGalleryImages':
        $galleryId = intval($_GET['gallery_id'] ?? 0);
        $page      = intval($_GET['page'] ?? 1);
        $perPage   = intval($_GET['per_page'] ?? 12);
        getGalleryImages($conn, $galleryId, $page, $perPage);
        break;

    default:
        echo json_encode(["error" => "Invalid action"]);
        break;
}

mysqli_close($conn);


// ================= FUNCTIONS ================= //

function getEvents($conn) {
    $sql = "SELECT id, title, date, start_time, end_time, location, images 
            FROM upcoming_events 
            ORDER BY date ASC 
            LIMIT 3";

    $result = mysqli_query($conn, $sql);

    $events = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $images = json_decode($row['images'], true);
        $mainImage = is_array($images) && count($images) > 0 ? $images[0] : "assets/img/default.jpg";

        $events[] = [
            "id"            => $row["id"],
            "title"         => $row["title"],
            "date"          => $row["date"],
            "time_label"    => $row["start_time"] . " - " . $row["end_time"],
            "location"      => $row["location"],
            "main_image_url"=> $mainImage
        ];
    }

    echo json_encode($events);
}

function getNews($conn) {
    $sql = "SELECT id, title, excerpt, published_at, image
            FROM news 
            ORDER BY published_at DESC 
            LIMIT 5";

    $result = mysqli_query($conn, $sql);

    $news = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $news[] = [
            "id"           => $row["id"],
            "title"        => $row["title"],
            "excerpt"      => $row["excerpt"],
            "published_at" => $row["published_at"],
            "image_url"    => $row["image"]
        ];
    }

    echo json_encode($news);
}

function getNewsDetail($conn, $id) {
    $sql = "SELECT * FROM news WHERE id = $id LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $news = mysqli_fetch_assoc($result);
    echo json_encode($news ?: ["error" => "News not found"]);
}

function getEventDetail($conn, $id) {
    $sql = "SELECT * FROM upcoming_events WHERE id = $id LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $event = mysqli_fetch_assoc($result);
    echo json_encode($event ?: ["error" => "Event not found"]);
}

function getGalleries($conn) {
    $sql = "SELECT g.id, g.title, g.image, g.created_at, COUNT(gi.id) as images_count
            FROM galleries g
            LEFT JOIN gallery_images gi ON g.id = gi.gallery_id
            GROUP BY g.id
            ORDER BY g.created_at DESC";

    $result = mysqli_query($conn, $sql);

    $galleries = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $galleries[] = $row;
    }

    echo json_encode($galleries);
}

function getGalleryImages($conn, $galleryId, $page, $perPage) {
    $offset = ($page - 1) * $perPage;

    // Get images
    $sql = "SELECT id, gallery_id, image, created_at
            FROM gallery_images
            WHERE gallery_id = $galleryId
            ORDER BY created_at DESC
            LIMIT $perPage OFFSET $offset";

    $result = mysqli_query($conn, $sql);
    $images = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $images[] = $row;
    }

    // Total count
    $countResult = mysqli_query($conn, "SELECT COUNT(*) as total FROM gallery_images WHERE gallery_id = $galleryId");
    $countRow = mysqli_fetch_assoc($countResult);
    $total = $countRow['total'] ?? 0;

    echo json_encode([
        "data"         => $images,
        "current_page" => $page,
        "per_page"     => $perPage,
        "total"        => (int)$total,
        "has_more"     => $total > $page * $perPage
    ]);
}
