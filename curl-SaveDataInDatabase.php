<?php

$dbHost = 'localhost';
$dbName = 'ebook_scraping';
$charset = 'UTF8';
$dbUser = 'root';
$dbPass = '';
$tableName = 'ebook';

try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=$charset", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

# Insert Date
$insertEbook = $pdo->prepare("
    INSERT INTO $tableName 
    (isbn, title, release, overview, authors)
    VALUES 
    (:ebookIsbn, :ebookTitle, :ebookRelease, :ebookOverview, :ebookAuthors)
");
# Scrape and store information in $ebooksInfo
foreach ($ebooksInfo as $ebookIsbn => $ebookDetails) 
{
    $insertEbook->execute(
    array(
    ':ebookIsbn' => $ebookIsbn,
    ':ebookTitle' => $ebookDetails['title'],
    ':ebookRelease' => $ebookDetails['release'],
    ':ebookOverview' => $ebookDetails['overview'],
    ':ebookAuthors' => implode(', ', $ebookDetails['authors'])
    )
    );
}

# Show Date
$selectEbooks = $pdo->prepare("SELECT * FROM $tableName");
$selectEbooks->execute();
echo '<table><tr><th>ISBN</th><th>Title</th><th>Overview</th><th>Author(s)</th><th>Release Date</th></tr>';

while ($row = $selectEbooks->fetch()) 
{
    echo '<tr>';
    echo '<td>' . $row['isbn'] . '</td>';
    echo '<td>' . $row['title'] . '</td>';
    echo '<td>' . $row['overview'] . '</td>';
    echo '<td>' . $row['authors'] . '</td>';
    echo '<td>' . $row['release'] . '</td>';
    echo '</tr>';
}

echo '</table>';


