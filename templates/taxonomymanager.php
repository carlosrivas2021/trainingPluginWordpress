<div class="wrap">
  <h1>Taxonomy Manager</h1>
  <?php settings_errors();
// if(isset($_POST["edit_taxonomy"])) echo $_POST["edit_taxonomy"];
?>

    <ul class="nav nav-tabs">
    <li class="<?php echo (isset($_POST["edit_taxonomy"])) ? '' : 'active' ?>"><a href="#tab-1">Your Taxonomies</a></li>
    <li class="<?php echo (isset($_POST["edit_taxonomy"])) ? 'active' : '' ?>">
      <a href="#tab-2">
        <?php echo (isset($_POST["edit_taxonomy"])) ? 'Edit' : 'Add' ?> Taxonomy
      </a>
    </li>
    <li class=""><a href="#tab-3">Export</a></li>
  </ul>

  <div class="tab-content">
    <div id="tab-1" class="tab-pane <?php echo (isset($_POST["edit_taxonomy"])) ? '' : 'active' ?>">
    <h3>Manage Taxonomy</h3>
<?php
$options = get_option('crivas_taxonomy') ?: array();

echo '<table class="cpt-table"><tr><th>ID</th><th>Singular Name</th><th class="text-center">Hierarchical</th><th class="text-center">Actions</th></tr>';
foreach ($options as $option) {
    $hierarchical = isset($option['hierarchical']) ? "TRUE" : "FALSE";
   

    echo "<tr><td>{$option['taxonomy']}</td><td>{$option['singular_name']}</td><td class=\"text-center\">{$hierarchical}</td><td class=\"text-center\">";

    echo '<form method="post" action="" class="inline-block">';

    echo '<input type="hidden" name="edit_taxonomy" value="' . $option['taxonomy'] . '">';
    submit_button('Edit', 'primary small', 'submit', false);
    echo ' </form>';

    echo " ";

    echo '<form method="post" action="options.php" class="inline-block">';
    settings_fields('crivas_plugin_tax_settings');
    echo '<input type="hidden" name="remove" value="' . $option['taxonomy'] . '">';
    submit_button('Delete', 'delete small', 'submit', false, array(
        'onclick' => 'return confirm("Are you sure you want to delete this Custom Taxonomy? The data associate with it will not be deleted.");',
    ));
    echo ' </form>';
    echo '</td></tr>';
}
echo '</table>';
?>
    </div>

    <div id="tab-2" class="tab-pane <?php echo (isset($_POST["edit_taxonomy"])) ? 'active' : '' ?>">

      <form method="post" action="options.php">
      <?php
settings_fields('crivas_plugin_tax_settings');
do_settings_sections('crivas_taxonomy');
submit_button();
?>
      </form>
    </div>

    <div id="tab-3" class="tab-pane">
      <h1>Export your taxonomies</h1>
      <?php foreach ($options as $option) { 
        $objects = isset($option['objects']) ? array_keys($option['objects']) : array();
        
        ?>
      <h3><?php echo $option['singular_name']; ?></h3>
      <pre class="prettyprint">
// Register Custom Post Type
function custom_taxonomy() {

  $labels = array(
    'name' => '<?php echo $option['singular_name'];?>',
    'singular_name' => '<?php echo $option['singular_name'];?>',
    'search_items' => 'Search <?php echo $option['singular_name'];?>',
    'all_items' => 'All <?php echo $option['singular_name'];?>',
    'parent_item' => 'Parent <?php echo $option['singular_name'];?>',
    'parent_item_colon' => 'Parent <?php echo $option['singular_name'];?>',
    'edit_item' => 'Edit <?php echo $option['singular_name'];?>',
    'update_item' => 'Update <?php echo $option['singular_name'];?>',
    'add_new_item' => 'Add New <?php echo $option['singular_name'];?>',
    'new_item_name' => 'New <?php echo $option['singular_name'];?> Name',
    'menu_name' => '<?php echo $option['singular_name'];?>',
  );

  $args = array(
    'hierarchical' => <?php echo isset($option['hierarchical']) ?: false ?>,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array('slug' => '<?php echo $option['taxonomy'];?>'),
  );

  register_taxonomy( 'genre', array( <?php foreach($objects as $object){ echo '\''.$object.'\',';}?> ), $args );

}
add_action( 'init', 'custom_taxonomy', 0 );

			</pre>
      <?php } ?>
    </div>

  </div>
</div>