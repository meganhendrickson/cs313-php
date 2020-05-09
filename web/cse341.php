<?php
    ob_start();
    include $_SERVER['DOCUMENT_ROOT'].'/common/header.php';
    $buffer=ob_get_contents();
    ob_end_clean();

    $title = "Hello There!";
    $buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i', '$1' . $title . '$3', $buffer);

    echo $buffer;
?>
    <main>
        <h1>CSE 341 Assignments</h1>
        <p>Coming Soon!</p>
    </main>
<?php include $_SERVER ['DOCUMENT_ROOT'].'/common/footer.php';?> 