<?php ?>
<!DOCTYPE html>
<html lang="nl" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Streamflix</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://vjs.zencdn.net/7.20.3/video-js.css" rel="stylesheet" />
    <link href="<?php echo (strpos($_SERVER['PHP_SELF'], '/pages/') !== false) ? '../assets/css/style.css' : 'assets/css/style.css'; ?>" rel="stylesheet">
</head>
<body class="bg-dark text-white">
<?php include dirname(__FILE__) . '/navbar.php'; ?>
    <div class="container mt-4">