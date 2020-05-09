<?php
    ob_start();
    include $_SERVER['DOCUMENT_ROOT'].'/common/header.php';
    $buffer=ob_get_contents();
    ob_end_clean();

    $title = "Hello There!";
    $buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i', '$1' . $title . '$3', $buffer);

    echo $buffer;
?>
    <div class="hello-image">
        <div class="hello-text">
            <h1>Well, Hello There!</h1>
            <p>Allow me to introduce myself: I'm a designer, a web developer-in-training, and a chocolate lover.
                I like to perfect every detail, put puzzles together, laugh at silly jokes, cry over bad design,
                and take walks in the sunshine. I'm still figuring out what I'm doing with my life. But hey,
                nice to meet you!
            </p>
        </div>
    </div>
<?php include $_SERVER['DOCUMENT_ROOT'].'/common/footer.php'?>