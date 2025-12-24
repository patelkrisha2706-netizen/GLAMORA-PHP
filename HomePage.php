<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>GLAMORA - Elegant Jewelry</title>
  <link rel="stylesheet" href="bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <style>
  /* :root {
    --bg-light: #EFE8E2;
    --primary: #D2BDAF;
    --accent: #B89278;
    --text-dark: #432A1C;
  }

  body {
    background-color: var(--bg-light);
    color: var(--text-dark); 
  }*/
/* 
  .custom-header {
    background-color: var(--primary);
    font-family: 'Segoe UI', sans-serif;
    position: sticky;
    top: 0;
    z-index: 999;
  }

  .custom-header .nav-link {
    color: var(--text-dark);
    padding: 0.5rem 1rem;
    transition: all 0.2s;
    font-weight: 500;
  }

  .custom-header .nav-link:hover {
    color: var(--accent);
    text-decoration: underline;
  }

  .search-wrapper .form-control:focus {
    box-shadow: none;
    border: none;
  }

  .badge {
    font-size: 0.6rem;
    padding: 0.25em 0.5em;
  }

  .card-title {
    font-size: 0.95rem;
    letter-spacing: 0.5px;
    font-weight: 600;
    color: var(--text-dark);
  }

  .card:hover {
    transform: scale(1.02);
    transition: transform 0.3s ease;
  }

  .top-style-filter button {
    border: 1px solid var(--text-dark);
    background-color: transparent;
    padding: 6px 12px;
    margin: 4px;
    font-size: 14px;
    text-transform: uppercase;
    color: var(--text-dark);
  }

  .top-style-filter button:hover {
    background-color: var(--accent);
    color: white;
  }

  footer {
    background-color: var(--text-dark);
    color: var(--bg-light);
  }

  footer h5 {
    color: var(--bg-light);
    font-weight: 600;
  }

  footer a {
    color: var(--bg-light);
    text-decoration: none;
  }

  footer a:hover {
    text-decoration: underline;
  }

  .logo {
    color: var(--accent);
  }

  .text-success {
    color: var(--accent) !important;
  } */
</style>

</head>
<body>

<?php  require 'DynamicHeader.php'?>
<?php  require 'Search.php'?>
<?php require 'CoverPage.php' ?>

<?php  require 'CategoryGrid.php' ?>

<?php require 'Section.php' ?>

<?php  require 'Footer.php'?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>