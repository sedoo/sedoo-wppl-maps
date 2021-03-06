<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="  crossorigin=""/>


<!-- THE HTML WHICH WILL HOST THE MAP -->
<div id="mapid"></div>

<script>
    // url used to query objects 
	var mbAttr = 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
			'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
			'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>';
    var mburl =  'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiZ25pY29sYXMzMSIsImEiOiJja2RpbTBteDkwNmRqMnJvaGM3Z2tncXRnIn0.yVz4MD1Jt_gJmHGNfM-Wbw';

    // empty array of future associative layers to title
    var layers = new Array();
    var markerArray = [];
</script>

<?php 

    // excluded content is set as an array
    $exclusions = 0;
    $exclusions = get_field('exclusion_de_contenus');
    $exclusions_list = implode(",", $exclusions);
    $array_of_post_Type_for_geoloc;

    if(get_field('types_de_contenus_a_afficher')) {

        // get post type list to be displayed in the map
        $t = get_field('types_de_contenus_a_afficher');

        // foreach post type
        foreach($t as $postttype) {
            $items = new WP_Query(array(
                'post_type' => $postttype,
                'numberposts' => -1,
                "posts_per_page" => -1,
                'post__not_in' => array($exclusions_list),
                'post_status' => 'publish'
                )
            );
            $postType = get_post_type_object($postttype);
            $postType = $postType->labels->singular_name; // human readable post type label
            ?>

            <!-- creating a layer for the map, one layer by post type -->
            <script>
                var nom_layer = <?php echo json_encode($postType) ?> ;
            	var <?php echo $postType; ?> = L.layerGroup();
                layers.push([<?php echo $postType; ?>, nom_layer]);
            </script>
            <?php 
            if ( $items->have_posts() ) : 
                while ( $items->have_posts() ) : $items->the_post();
                    if(get_field('geolocalisation_yesno', get_the_ID()) == true) {
                        
                        $infobulle = get_field('contenu_infobulle', get_the_ID());   
                        $lat = get_field('latitude', get_the_ID());   
                        $lon = get_field('longitude', get_the_ID());
                        $titre = get_the_title();
            ?>
                <!-- pushing the marker in the layer with the bind popup event -->
                <script>
                    markerArray.push(L.marker([<?php echo $lat; ?>, <?php echo $lon; ?>]).bindPopup("<h3><?php echo ucfirst(get_the_title()); ?></h3><p><?php echo $infobulle; ?></p><a href='<?php the_permalink(); ?>'>Voir plus</a>").addTo(<?php echo $postType; ?>)); // add marker to his post type layer
                </script>          
            <?php 
                    }
                endwhile;
            ?> 
            <?php 
            endif; 
            wp_reset_query();
        }
    }
   
?>                
<script>

    var layers_list = new Array(); // the list of default displayed layers
    var layers_corresp = new Array(); // list of layers title to layers content relation

    var overlays = {}; // overlay of marker, one layer for one post type
    

    // magic happen here
    for (var i = 0; i < layers.length; i++) {
            layers_list.push(layers[i][0]); // default displayed layers
            overlays[layers[i][1]] = layers[i][0];
    }

    var grayscale   = L.tileLayer(mburl, {id: 'mapbox/light-v9', tileSize: 512, zoomOffset: -1, attribution: mbAttr}), // the two ground display options
    streets  = L.tileLayer(mburl, {id: 'mapbox/streets-v11', tileSize: 512, zoomOffset: -1, attribution: mbAttr});     //

    layers_list.push(grayscale);

    var map = L.map('mapid', {
        center: [48.8534, 2.3488],
        zoom: 7,
        layers: layers_list
    });

    // baselayers for the map
    var baseLayers = {
        "Grayscale": grayscale,
        "Streets": streets
    };
    var group = L.featureGroup(markerArray).addTo(map);

    // fitting bounds of the map, to display all marker with the perfect zoom (and 20px of padding)

    console.log(group.getBounds());
    if(layers.length == 0) {
    }
    else {
        map.fitBounds(group.getBounds(), {padding: L.point(20, 20)});
    }
    L.control.layers(baseLayers, overlays).addTo(map);
</script>