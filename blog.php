<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Website Riano</title>
    <link rel="stylesheet" href="blog.css"> <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <script src="script.js"></script>
</head>
<body>
    <h1>Blog</h1>
    <nav>
        <a href="index.html">Home</a> | 
        <a href="gallery.html">Gallery</a> | 
        <a href="blog.php">Blog</a> | <a href="contact.html">Contact</a>
    </nav>
    <hr>

 <div class="blog-container" id="blog-articles-container">
    <?php
    require_once 'artikel.php'; 

    if ($conn->connect_error) {
        echo '<p class="error-message">Maaf, kami tidak dapat memuat artikel saat ini. Silakan coba lagi nanti.</p>';
    } else {
        $sql = "SELECT id, title, content FROM articles ORDER BY created_at DESC";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="blog-article">';
                echo '<h2>' . htmlspecialchars($row['title']) . '</h2>';
                echo '<p>' . nl2br(htmlspecialchars($row['content'])) . '</p>';
                echo '</div>';
            }
        } else {
            echo '<p class="no-articles-message">Belum ada artikel blog yang tersedia.</p>';
        }

        $conn->close();
    }
    ?>
</div>

    <footer class="footer">
        <div class="footer-content-wrapper">
            <p>© Riano</p>
            <div class="social-links">
                <a href="#" aria-label="Instagram" title="Follow us on Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" aria-label="Twitter" title="Follow us on Twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" aria-label="Discord" title="Join our Discord community"><i class="fab fa-discord"></i></a>
                <a href="#" aria-label="Facebook" title="Follow us on Facebook"><i class="fab fa-facebook"></i></a>
            </div>
        </div>
    </footer>

    </body>
</html>
