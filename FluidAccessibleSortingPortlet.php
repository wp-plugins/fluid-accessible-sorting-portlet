<?php
/*
Plugin Name: Fluid Accessible Sorting Portlet
Plugin URI: http://wordpress.org/extend/plugins/fluid-accessible-sorting-portlet/
Description: WAI-ARIA Enabled Sorting Portlet Plugin for Wordpress
Author: Theofanis Oikonomou
Version: 1
Author URI: http://www.iti.gr/iti/people/ThOikon.html
*/
include_once 'getRecentPosts.php';
include_once 'getRecentComments.php';
include_once 'getCategories.php';
include_once 'getMeta.php';

add_action("plugins_loaded", "FluidAccessibleSortingPortlet_init");
function FluidAccessibleSortingPortlet_init() {
    register_sidebar_widget(__('Fluid Accessible Sorting Portlet'), 'widget_FluidAccessibleSortingPortlet');
    register_widget_control(   'Fluid Accessible Sorting Portlet', 'FluidAccessibleSortingPortlet_control', 200, 200 );
    if ( !is_admin() && is_active_widget('widget_FluidAccessibleSortingPortlet') ) {
        wp_register_script('InfusionAll', ( get_bloginfo('wpurl') . '/wp-content/plugins/FluidAccessibleSortingPortlet/lib/InfusionAll.js'));
        wp_enqueue_script('InfusionAll');

        wp_register_script('FluidAccessibleSortingPortlet', ( get_bloginfo('wpurl') . '/wp-content/plugins/FluidAccessibleSortingPortlet/lib/FluidAccessibleSortingPortlet.js'));
        wp_enqueue_script('FluidAccessibleSortingPortlet');

        wp_register_style('FluidAccessibleSortingPortlet_css', ( get_bloginfo('wpurl') . '/wp-content/plugins/FluidAccessibleSortingPortlet/lib/FluidAccessibleSortingPortlet.css'));
        wp_enqueue_style('FluidAccessibleSortingPortlet_css');
    }
}

function widget_FluidAccessibleSortingPortlet($args) {
    extract($args);

    $options = get_option("widget_FluidAccessibleSortingPortlet");
    if (!is_array( $options )) {
        $options = array(
                'title' => 'Fluid Accessible Sorting Portlet',
            'categories' => 'Categories',
            'meta' => 'Meta',
            'recentPosts' => 'Recent Posts',
            'recentComments' => 'Recent Comments'
        );
    }

    echo $before_widget;
    echo $before_title;
    echo $options['title'];
    echo $after_title;

    //Our Widget Content
    FluidAccessibleSortingPortletContent();
    echo $after_widget;
}

function FluidAccessibleSortingPortletContent() {
    $recentPosts = get_recent_posts();
    $recentComments = get_recent_comments();
    $categories = get_my_categories();
    $meta = get_my_meta();

    $options = get_option("widget_FluidAccessibleSortingPortlet");
    if (!is_array($options)) {
        $options = array(
            'title' => 'Fluid Accessible Sorting Portlet',
            'categories' => 'Categories',
            'meta' => 'Meta',
            'recentPosts' => 'Recent Posts',
            'recentComments' => 'Recent Comments'
        );
    }

    echo '<div class="demo" role="application">
<table id="portlet-reorderer-root">
  <tbody>
    <tr>
      <td id="c1">
        <div class="portlet" id="portlet1">
          <div class="title">' . $options['recentPosts'] . '</div>
          <div class="content">
            <ul>
                ' . $recentPosts . '
            </ul>
          </div>
        </div>
        <div class="portlet" id="portlet2">
          <div class="title">' . $options['recentComments'] . '</div>
          <div class="content">
            <ul>
                ' . $recentComments . '
            </ul>
          </div>
        </div>
      </td>
      <td id="c2">
        <div class="portlet" id="portlet3">
          <div class="title">' . $options['categories'] . '</div>
          <div class="content">
            <ul>
                ' . $categories . '
            </ul>
          </div>
        </div>
      </td>
      <td id="c3">
        <div class="portlet" id="portlet4">
          <div class="title">' . $options['meta'] . '</div>
          <div class="content">
            <ul>
                ' . $meta . '
            </ul>
          </div>
        </div>
    </tr>
  </tbody>
</table>
</div>';
}

function FluidAccessibleSortingPortlet_control() {
    $options = get_option("widget_FluidAccessibleSortingPortlet");
    if (!is_array( $options )) {
        $options = array(
                'title' => 'Fluid Accessible Sorting Portlet',
            'categories' => 'Categories',
            'meta' => 'Meta',
            'recentPosts' => 'Recent Posts',
            'recentComments' => 'Recent Comments'
        );
    }

    if ($_POST['FluidAccessibleSortingPortlet-SubmitTitle']) {
        $options['title'] = htmlspecialchars($_POST['FluidAccessibleSortingPortlet-WidgetTitle']);
        update_option("widget_FluidAccessibleSortingPortlet", $options);
    }
    if ($_POST['FluidAccessibleSortingPortlet-SubmitCategories']) {
        $options['categories'] = htmlspecialchars($_POST['FluidAccessibleSortingPortlet-WidgetCategories']);
        update_option("widget_FluidAccessibleSortingPortlet", $options);
    }
    if ($_POST['FluidAccessibleSortingPortlet-SubmitMeta']) {
        $options['meta'] = htmlspecialchars($_POST['FluidAccessibleSortingPortlet-WidgetMeta']);
        update_option("widget_FluidAccessibleSortingPortlet", $options);
    }
    if ($_POST['FluidAccessibleSortingPortlet-SubmitRecentPosts']) {
        $options['recentPosts'] = htmlspecialchars($_POST['FluidAccessibleSortingPortlet-WidgetRecentPosts']);
        update_option("widget_FluidAccessibleSortingPortlet", $options);
    }
    if ($_POST['FluidAccessibleSortingPortlet-SubmitRecentComments']) {
        $options['recentComments'] = htmlspecialchars($_POST['FluidAccessibleSortingPortlet-WidgetRecentComments']);
        update_option("widget_FluidAccessibleSortingPortlet", $options);
    }
    ?>
    <p>
        <label for="FluidAccessibleSortingPortlet-WidgetTitle">Widget Title: </label>
        <input type="text" id="FluidAccessibleSortingPortlet-WidgetTitle" name="FluidAccessibleSortingPortlet-WidgetTitle" value="<?php echo $options['title'];?>" />
        <input type="hidden" id="FluidAccessibleSortingPortlet-SubmitTitle" name="FluidAccessibleSortingPortlet-SubmitTitle" value="1" />
    </p>
    <p>
        <label for="FluidAccessibleSortingPortlet-WidgetCategories">Translation for "Categories": </label>
        <input type="text" id="FluidAccessibleSortingPortlet-WidgetCategories" name="FluidAccessibleSortingPortlet-WidgetCategories" value="<?php echo $options['categories'];?>" />
        <input type="hidden" id="FluidAccessibleSortingPortlet-SubmitCategories" name="FluidAccessibleSortingPortlet-SubmitCategories" value="1" />
    </p>
    <p>
        <label for="FluidAccessibleSortingPortlet-WidgetMeta">Translation for "Meta": </label>
        <input type="text" id="FluidAccessibleSortingPortlet-WidgetMeta" name="FluidAccessibleSortingPortlet-WidgetMeta" value="<?php echo $options['meta'];?>" />
        <input type="hidden" id="FluidAccessibleSortingPortlet-SubmitMeta" name="FluidAccessibleSortingPortlet-SubmitMeta" value="1" />
    </p>
    <p>
        <label for="FluidAccessibleSortingPortlet-WidgetRecentPosts">Translation for "Recent Posts": </label>
        <input type="text" id="FluidAccessibleSortingPortlet-WidgetRecentPosts" name="FluidAccessibleSortingPortlet-WidgetRecentPosts" value="<?php echo $options['recentPosts'];?>" />
        <input type="hidden" id="FluidAccessibleSortingPortlet-SubmitRecentPosts" name="FluidAccessibleSortingPortlet-SubmitRecentPosts" value="1" />
    </p>
    <p>
        <label for="FluidAccessibleSortingPortlet-WidgetRecentComments">Translation for "Recent Comments": </label>
        <input type="text" id="FluidAccessibleSortingPortlet-WidgetRecentComments" name="FluidAccessibleSortingPortlet-WidgetRecentComments" value="<?php echo $options['recentComments'];?>" />
        <input type="hidden" id="FluidAccessibleSortingPortlet-SubmitRecentComments" name="FluidAccessibleSortingPortlet-SubmitRecentComments" value="1" />
    </p>
    
    <?php
}

?>
