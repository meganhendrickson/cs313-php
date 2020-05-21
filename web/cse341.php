<?php
    ob_start();
    include $_SERVER['DOCUMENT_ROOT'].'/common/header.php';
    $buffer=ob_get_contents();
    ob_end_clean();

    $title = "CSE 341 Assignments";
    $buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i', '$1' . $title . '$3', $buffer);

    echo $buffer;
?>
    <main>
        <h1>CSE 341 Assignments</h1>
        <ul class="assignment-menu">
            <li><a href="/shopping/">Shopping Cart</a></li>
            <li><a href="/expensetracker/">Expense Tracker</a>(in progress)</li>
        </ul>
    </main>
<?php include $_SERVER ['DOCUMENT_ROOT'].'/common/footer.php';?> 