<?php
function ths_page_admin() {

    $config = get_option('ths_config');

    ?>
    <div class="wrap">
            <div id="icon-options-general" class="icon32"></div>
            <h2><?php _e('Thesaurus record settings', 'ths'); ?></h2>

            <form method="post" action="options.php">

                <?php settings_fields('ths-settings-group'); ?>

                <table class="form-table">
                    <tbody>
                        <tr valign="top">
                            <th scope="row"><?php _e('Plugin page', 'ths'); ?>:</th>
                            <td><input type="text" name="ths_config[plugin_slug]" value="<?php echo ($config['plugin_slug'] != '' ? $config['plugin_slug'] : 'ths'); ?>" class="regular-text code"></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><?php _e('Filter query', 'ths'); ?>:</th>
                            <td><input type="text" name="ths_config[initial_filter]" value='<?php echo $config['initial_filter'] ?>' class="regular-text code"></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><?php _e('AddThis profile ID', 'ths'); ?>:</th>
                            <td><input type="text" name="ths_config[addthis_profile_id]" value="<?php echo $config['addthis_profile_id'] ?>" class="regular-text code"></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><?php _e('Google Analytics code', 'ths'); ?>:</th>
                            <td><input type="text" name="ths_config[google_analytics_code]" value="<?php echo $config['google_analytics_code'] ?>" class="regular-text code"></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><?php _e('Fulltext', 'ths'); ?>:</th>
                            <td>
                                <label for="present_alternative_links">
                                    <input type="checkbox" name="ths_config[alternative_links]" value="true" id="present_alternative_links" <?php echo (isset($config['alternative_links']) ?  " checked='true'" : '') ;?> ></input>
                                    <?php _e('Present alternative fulltext links', 'ths'); ?>
                                </label>
                            </td>
                        </tr>

                        <?php
                        if ( function_exists( 'pll_the_languages' ) ) {
                            $available_languages = pll_languages_list();
                            $available_languages_name = pll_languages_list(array('fields' => 'name'));
                            $count = 0;
                            foreach ($available_languages as $lang) {
                                $key_name = 'plugin_title_' . $lang;
                                $home_url = 'home_url_' . $lang;

                                echo '<tr valign="top">';
                                echo '    <th scope="row"> ' . __("Home URL", "ths") . ' (' . $available_languages_name[$count] . '):</th>';
                                echo '    <td><input type="text" name="ths_config[' . $home_url . ']" value="' . $config[$home_url] . '" class="regular-text code"></td>';
                                echo '</tr>';

                                echo '<tr valign="top">';
                                echo '    <th scope="row"> ' . __("Page title", "ths") . ' (' . $available_languages_name[$count] . '):</th>';
                                echo '    <td><input type="text" name="ths_config[' . $key_name . ']" value="' . $config[$key_name] . '" class="regular-text code"></td>';
                                echo '</tr>';
                                $count++;
                            }
                        }else{
                            echo '<tr valign="top">';
                            echo '   <th scope="row">' . __("Page title", "ths") . ':</th>';
                            echo '   <td><input type="text" name="ths_config[plugin_title]" value="' . $config["plugin_title"] . '" class="regular-text code"></td>';
                            echo '</tr>';
                        }

                        ?>
                        <tr valign="top">
                            <th scope="row"><?php _e('Search filters', 'ths');?>:</th>

                            <?php
                              if(!isset($config['available_filter'])){
                                $config['available_filter'] = 'Main subject;Publication type;Database;Publication country;Limits;Language;Journal;Year';
                                $order = explode(';', $config['available_filter'] );

                              }else {
                                $order = explode(';', $config['available_filter'] );
                            }

                            ?>

                            <td>
                              <table border=0>
                                <tr>
                                <td>
                                    <p align="left"><?php _e('Available', 'ths');?><br>
                                      <ul id="sortable1" class="droptrue">
                                      <?php
                                      if(!in_array('Main subject', $order) && !in_array('Main subject ', $order) ){
                                        echo '<li class="ui-state-default" id="Main subject">'.translate('Main subject','ths').'</li>';
                                      }
                                      if(!in_array('Publication type', $order) && !in_array('Publication type ', $order) ){
                                        echo '<li class="ui-state-default" id="Publication type">'.translate('Publication type','ths').'</li>';
                                      }
                                      if(!in_array('Database', $order) && !in_array('Database ', $order) ){
                                        echo '<li class="ui-state-default" id="Database">'.translate('Database','ths').'</li>';
                                      }
                                      if(!in_array('Publication country', $order) && !in_array('Publication country ', $order) ){
                                        echo '<li class="ui-state-default" id="Publication country">'.translate('Publication country','ths').'</li>';
                                      }
                                      if(!in_array('Limits', $order) && !in_array('Limits ', $order) ){
                                        echo '<li class="ui-state-default" id="Limits">'.translate('Limits','ths').'</li>';
                                      }
                                      if(!in_array('Language', $order) && !in_array('Language ', $order) ){
                                        echo '<li class="ui-state-default" id="Language">'.translate('Language','ths').'</li>';
                                      }
                                      if(!in_array('Journal', $order) && !in_array('Journal ', $order) ){
                                        echo '<li class="ui-state-default" id="Journal">'.translate('Journal','ths').'</li>';
                                      }
                                      if(!in_array('Year', $order) && !in_array('Year ', $order) ){
                                        echo '<li class="ui-state-default" id="Year">'.translate('Year','ths').'</li>';
                                      }
                                      ?>
                                      </ul>

                                    </p>
                                </td>

                                <td>
                                    <p align="left"><?php _e('Selected', 'ths');?> <br>
                                      <ul id="sortable2" class="sortable-list">
                                      <?php
                                      foreach ($order as $index => $item) {
                                        $item = trim($item); // Important
                                        echo '<li class="ui-state-default" id="'.$item.'">'.translate($item ,'ths').'</li>';
                                      }
                                      ?>
                                      </ul>
                                      <input type="hidden" id="order_aux" name="ths_config[available_filter]" value="<?php echo trim($config['available_filter']); ?> " >
                                    </p>
                                </td>
                                </tr>
                             </table>
                            </td>
                        </tr>

                    </tbody>
                </table>

                <p class="submit">
                <input type="submit" class="button-primary" value="<?php _e('Save changes') ?>" />
                </p>

            </form>
        </div>
        <script type="text/javascript">
            var $j = jQuery.noConflict();

            $j( function() {
              $j( "ul.droptrue" ).sortable({
                connectWith: "ul"
              });

              $j('.sortable-list').sortable({

                connectWith: 'ul',
                update: function(event, ui) {
                  var changedList = this.id;
                  var order = $j(this).sortable('toArray');
                  var positions = order.join(';');
                  $j('#order_aux').val(positions);

                }
              });
            } );
        </script>

        <?php
}
?>
