<?php

namespace joey\uploader\Settings;

class SettingsStyle
{
    static function display_store_form_content(): void
    {
        $args = array(
            'post_type' => 'Stores',
            'post_status' => 'publish',
            'numberposts' => -1
        );

        $my_posts = get_posts($args);
        echo '<div style="display: flex;justify-content:space-between;flex-direction: row;">
              <div style="display: flex; flex-direction: column;width: 15%; justify-content: space-evenly" >
                <p>Winkel naam</p>
                <p>Straat</p>
                <p>Huisnummer</p>
                <p>Postcode</p>
                <p>Gemeente</p>
              </div>
              <div style="display: flex; flex-direction: column;width: 100%;margin-top: 10px;">
                    <input required type="text" name="store_name">
                    <input style="margin-top: 12px;" required type="text" name="store_street">
                    <input style="margin-top: 12px;" required type="text" name="store_house_number">
                    <input style="margin-top: 12px;" required type="text" name="store_postal_code">
                    <input style="margin-top: 12px;" required type="text" name="store_city" disabled>
              </div>
            </div>';
        submit_button('Save Winkel');


        echo '<table id="stores">
    <thead>
                    <th>ID</th>
                    <th>Winkel</th>
                    <th>Straat</th>
                    <th>Huisnummer</th>
                    <th>Postcode</th>
                    <th>Stad</th>
                    <th>Edit / Delete</th>
    </thead>
    <tbody>';
        foreach ($my_posts as $key => $data) {
            $metadata = get_post_meta($data->ID);
            if (isset($metadata['store_name'][0])) {
                $trashurl = wp_nonce_url(admin_url("post.php?action=trash&post=$data->ID"), "trash-post_$data->ID");
                $editurl = wp_nonce_url(admin_url("post.php?action=edit&post=$data->ID"), "edit-post_$data->ID");
                echo '<tr style="text-align: center">
            <td>' . $data->ID . '</td>
            <td>' . $metadata['store_name'][0] . '</td>
            <td>' . $metadata['store_street'][0] . '</td>
            <td>' . $metadata['store_house_number'][0] . '</td>
            <td>' . $metadata['store_postal_code'][0] . '</td>
            <td>' . $metadata['store_city'][0] . '</td>
            <td style="justify-self: center;justify-content: center;display:flex;"><a style="margin-right: 25px;" href="' . $editurl . '"><span class="dashicons dashicons-edit"></span>
            </a><a href="' . $trashurl . '"><span class="dashicons dashicons-trash"></span></a></td>
            </tr>';
            }
        }
        echo '</tbody>';

        echo '</table>';
        echo "<script>jQuery(document).ready(function($) {
    $('#stores').DataTable({order: [[0, 'desc']],});
} );</script>";

    }


    static function display_leverancier_form_content(): void
    {
        $args = array(
            'post_type' => 'Leveranciers',
            'post_status' => 'publish',
            'numberposts' => -1

        );
        $my_posts = get_posts($args);

        echo ' <div style="display: flex;justify-content:space-between;flex-direction: row;">
              <div style="display: flex; flex-direction: column;width: 15%; justify-content: space-evenly" >
                <p>Leverancier naam</p>
                <p>Specialisatie</p>
              </div>
              <div style="display: flex; flex-direction: column;width: 100%;margin-top: 10px;">
                    <input required type="text" name="leverancier_name">
                    <input style="margin-top: 12px;" required type="text" name="leverancier_specialiteit">
              </div>
            </div>';

        submit_button('Save Leverancier');


        echo '<table id="leverancier">
    <thead>
        <th>ID</th>
        <th>Leverancier Naam</th>
        <th>Leverancier specialiteit</th>
        <th>Edit / Delete</th>
    </thead>
    <tbody>';
        foreach ($my_posts as $key => $data) {
            $metadata = get_post_meta($data->ID);
            if (isset($metadata['leverancier_name'][0])) {
                $trashurl = wp_nonce_url(admin_url("post.php?action=trash&post=$data->ID"), "trash-post_$data->ID");
                $editurl = wp_nonce_url(admin_url("post.php?action=edit&post=$data->ID"), "edit-post_$data->ID");
                echo '<tr style="text-align: center">
            <td>' . $data->ID . '</td>
            <td>' . $metadata['leverancier_name'][0] . '</td>
            <td>' . $metadata['leverancier_specialiteit'][0] . '</td>
            <td style="justify-self: center;justify-content: center;display:flex;"><a style="margin-right: 25px;" href="' . $editurl . '"><span class="dashicons dashicons-edit"></span>
            </a><a href="' . $trashurl . '"><span class="dashicons dashicons-trash"></span></a></td>
            </tr>';
            }
        }
        echo '</tbody>';

        echo '</table>';
        echo "<script>jQuery(document).ready(function($) {
    $('#leverancier').DataTable({order: [[0, 'desc']],});
} );</script>";


    }


    static function display_product_form_content(): void
    {
        $args = array(
            'post_type' => 'Products',
            'post_status' => 'publish',
            'numberposts' => -1
        );

        $argsLev = array(
            'post_type' => 'Leveranciers',
            'post_status' => 'publish',
            'numberposts' => -1
        );
        $my_posts = get_posts($args);
        $my_posts_lev = get_posts($argsLev);

        echo ' <div style="display: flex;justify-content:space-between;flex-direction: row;">
              <div style="display: flex; flex-direction: column;width: 15%; justify-content: space-evenly" >
                <p>Product Naam</p>
                <p>Leverancier ID</p>
              </div>
              <div style="display: flex; flex-direction: column;width: 100%;margin-top: 10px;">
                    <input style="margin-bottom: 15px;" required type="text" name="product_name">
                    <select id="levid" name="leverancier_id">';
        foreach ($my_posts_lev as $key => $data) {
            $metadata = get_post_meta($data->ID);
            if (isset($metadata['leverancier_name'][0])) {
                echo '<option required selected name="leverancier_id" value="' . $data->ID . '">' . $metadata['leverancier_name'][0] . '</option>';
            }
        }

        echo '</select>
              </div>
            </div>';

        echo "<script>jQuery(document).ready(function($) {
    $('#levid').select2();
} );</script>";
        submit_button('Save Product');


        echo '<table id="products">
    <thead>
        <th>ID</th>
        <th>Product Naam</th>
        <th>Edit / Delete</th>
    </thead>
    <tbody>';
        foreach ($my_posts as $key => $data) {
            $metadata = get_post_meta($data->ID);
            if (isset($metadata['product_name'][0])) {
                $trashurl = wp_nonce_url(admin_url("post.php?action=trash&post=$data->ID"), "trash-post_$data->ID");
                $editurl = wp_nonce_url(admin_url("post.php?action=edit&post=$data->ID"), "edit-post_$data->ID");
                echo '<tr style="text-align: center">
            <td>' . $data->ID . '</td>
            <td>' . $metadata['product_name'][0] . '</td>
            <td style="justify-self: center;justify-content: center;display:flex;"><a style="margin-right: 25px;" href="' . $editurl . '"><span class="dashicons dashicons-edit"></span>
            </a><a href="' . $trashurl . '"><span class="dashicons dashicons-trash"></span></a></td>
            </tr>';
            }
        }
        echo '</tbody>';

        echo '</table>';
        echo "<script>jQuery(document).ready(function($) {
    $('#products').DataTable({order: [[0, 'desc']],});
} );</script>";

    }


    static function display_link_form_content(): void
    {
        $argsProd = array(
            'post_type' => 'Products',
            'post_status' => 'publish',
            'numberposts' => -1
        );
        $argsLev = array(
            'post_type' => 'Leveranciers',
            'post_status' => 'publish',
            'numberposts' => -1
        );
        $my_posts_prod = get_posts($argsProd);
        $my_posts_lev = get_posts($argsLev);


        ?> <table id="link">
    <thead>
        <th>ID</th>
        <th>Product Naam</th>
        <th>Leverancier Naam</th>
    </thead>
    <tbody> <?php
        foreach ($my_posts_prod as $key => $data) {
            $metadata = get_post_meta($data->ID);
            if (isset($metadata['product_name'][0])) {
                echo '<tr style="text-align: center">
            <td>' . $data->ID . '</td>
            <td>' . $metadata['product_name'][0] . '</td>';
                foreach ($my_posts_lev as $sleutel => $data_lev) {
                    $metadata_lev = get_post_meta($data_lev->ID);
                    if (isset($metadata['leverancier_id'][0])) {
                        if ($metadata['leverancier_id'][0] == $data_lev->ID) {
                            echo '<td>' . $metadata_lev['leverancier_name'][0] . '</td>';
                        }
                    }
                }
                echo '</tr>';
            }
        }
        echo '</tbody>';

        echo '</table>';
        echo "<script>jQuery(document).ready(function($) {
    $('#link').DataTable({order: [[0, 'desc']],});
} );</script>";

    }

}