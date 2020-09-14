<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="  crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>

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

    $exclusions = 0;
    $exclusions = get_field('exclusion_de_contenus');
    $exclusions_list = implode(",", $exclusions);
    $array_of_post_Type_for_geoloc;
    if(get_field('types_de_contenus_a_afficher')) {
        $t = get_field('types_de_contenus_a_afficher');
        foreach($t as $postttype) {
            $items = new WP_Query(array(
                'post_type' => $postttype,
                'numberposts' => -1,
                'post__not_in' => array($exclusions_list),
                'post_status' => 'publish'
                )
            );
            $postType = get_post_type_object($postttype);
            $postType = $postType->labels->singular_name; // human readable post type label
            ?>
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

    var baseLayers = {
        "Grayscale": grayscale,
        "Streets": streets
    };
   // var group = L.featureGroup(markerArray).addTo(map);
   // map.fitBounds(group.getBounds());
    L.control.layers(baseLayers, overlays).addTo(map);
</script>