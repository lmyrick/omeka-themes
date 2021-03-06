<?php head(array('bodyid'=>'home')); 

ini_set('display_errors',1); 
error_reporting(E_ALL);

?>

<div id="primary">
    <?php if (get_theme_option('Homepage Text')): ?>
    <p><?php echo get_theme_option('Homepage Text'); ?></p>
    <?php endif; ?>

<?php 
    
    $collectionTitle = '';
    $collectionIDs = collection_order_array();
    $num_of_collections = count($collectionIDs);
    $div_counter = 1;

    foreach ($collectionIDs as $collectionID) {
      
      $collection = get_collection_by_id($collectionID);
	  $collectionName = collection('name', array(), $collection);
      //$collection_link = link_to_collection($collectionTitle, array(), 'show', $collection);
	  $collection_link = browsealllink_to_collection($collectionTitle, array(), 'show', $collection);
	  
      $collection_items = get_items(array('sort_field' => 'Dublin Core,Audience','sort_dir' => 'a','collection' => $collection['id']),9000);
      $num_of_collection_items = count($collection_items); 
      set_items_for_loop($collection_items);
      $collection_item_list = array();
      
      while (loop_items()) {
        get_current_item();
        array_push($collection_item_list, array('thumb'=>item_square_thumbnail(array('alt'=>item('Dublin Core', 'Title'))),
                                                  'link'=>item_uri(), 'name'=>item('Dublin Core', 'Title')));
      }
                
      echo '<h1 style="display: inline;">' . $collectionName . '</h1>' . $collection_link;
      echo '<hr style="visibility: hidden; margin-top: 2px; margin-bottom: 4px;" />';
      echo '<ul id="collection'.$div_counter.'" class="slider">';

      for ($i=0; $i < $num_of_collection_items; $i++) { 
        echo '<li>';
        echo '<a href="'.$collection_item_list[$i]['link'].'" rel="tooltip" title="'.$collection_item_list[$i]['name'].'">'.$collection_item_list[$i]['thumb'].'</a>';
        echo '</li>';
      }

      echo '</ul>';
      echo '<hr style="visibility: hidden; margin-top: 3px; margin-bottom: 3px;" />';
      $div_counter++;
    
    }

  echo "<script> \n";
  echo "!function( $ ){ \n";
  echo "$(function () { \n";

  for ($k=1; $k <= $num_of_collections; $k++) { 
      echo "$('#collection".$k."').bxSlider({ \n";
      echo "displaySlideQty: 7, \n"; 
      echo "moveSlideQty: 7 \n";
      echo " }); \n";
    }

  echo "$('a[rel=tooltip]').tooltip(); \n";
  echo "}); \n";
  echo "}( window.jQuery ) \n";
  echo "</script> \n";

  foot();

 ?>

