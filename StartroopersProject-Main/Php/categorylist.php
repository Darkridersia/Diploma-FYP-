  <?php
include_once "Php/config.php";

$sql3 = "SELECT * FROM category";
$result3 = mysqli_query($conn, $sql3);
$categories = mysqli_fetch_all($result3, MYSQLI_ASSOC);


?>
  
  
  
  
  
  <?php foreach ($categories as $category) :  ?>
                                <li><a class="dropdown-item" href="category.php?category_keyword=<?php echo $category['CategoryTitle'];  ?>"><?php echo $category['CategoryTitle'];  ?></a></li>

                                <li>
                                    <hr class="dropdown-divider" />
                                </li>
                            <?php endforeach; ?>