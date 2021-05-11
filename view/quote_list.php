<html>
<header>

<link rel="stylesheet" href="css/main.css">
</header>
<body>
<section id="navigation" class="navigation" name="navigation">
<form action="." method="get" id="make_selection">
        <section id="dropmenus" class="dropmenus">
            <?php if ($cate_arr) { ?>
            <label>Category:</label>
            <select name="category_id">
                <option value="0">View All Categories</option>
                <?php foreach ($cate_arr as $cate) : ?>
                    <option value="<?= $cate['id']; ?>">               
                    <?= $cate['category']; ?>
                </option>
                <?php endforeach; ?>
            </select>
            <?php } ?>


            <?php if ($author_arr) { ?>
            <label>Authors:</label>
            <select name="author_id">
                <option value="0">View All Authors</option>
                <?php foreach ($author_arr as $auth) : ?>
                    <option value="<?= $auth['id']; ?>">               
                    <?= $auth['author']; ?>
                </option>
                <?php endforeach; ?>
            </select>
            <?php } ?>   
        </section>
        <input type='submit' value='Search' />
    </form>
</section>
<section id="table_display" class="table_display">
<table>
 <?php
    if(!empty($quotes_arr)){
    foreach($quotes_arr as $quotes) :?>
   
    <tr> 
    <td colspan="2" id="quote_line" class="quote_line" name="quote_line">
    <?= $quotes['quote']; ?>
    </td>
    </tr>
    <tr id="detail_line" class="detail_line" name="detail_line">
    <td id="author_box" class="author_box" name="author_box">
    <?= $quotes['author']; ?>
    </td>
    <td id="category_box" class="category_box" name="category_box">
    <?= $quotes['category']; ?>
    </td>
    </tr>
    

    <?php endforeach; 
    }?>
</table>
</section>

</body>
</html>