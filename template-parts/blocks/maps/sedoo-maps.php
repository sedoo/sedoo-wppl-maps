<div class="sedoo_ol_maps">
    <div id="map" class="map"></div>
    <div id="popup" class="ol-popup">
        <a href="#" id="popup-closer" class="ol-popup-closer"></a>
        <div id="popup-content"></div>
    </div>
</div>

<script type="text/javascript">
    var map = new ol.Map({
        target: 'map',
        layers: [
            new ol.layer.Tile({
            source: new ol.source.OSM()
            })
        ],
        view: new ol.View({
            center: ol.proj.fromLonLat([37.41, 8.82]),
            zoom: 4
        })
    });
    var container = document.getElementById('popup');
    var content = document.getElementById('popup-content');
    var closer = document.getElementById('popup-closer');

    //////////////
    /// ADD MARKER
    ///////////
    var overlay = new ol.Overlay({
        element: container,
        autoPan: true,
        autoPanAnimation: {
            duration: 250
        }
    });
    map.addOverlay(overlay);

    closer.onclick = function() {
        overlay.setPosition(undefined);
        closer.blur();
        return false;
    };
</script>

<?php 
    $array_of_post_Type_for_geoloc;
    if(get_field('types_de_contenus_a_afficher')) {
        $t = get_field('types_de_contenus_a_afficher');
        foreach($t as $postttype) {
            $array_of_post_Type_for_geoloc[] = $postttype;
        }
    }
    $items = new WP_Query(array(
		'post_type' => $array_of_post_Type_for_geoloc,
		'numberposts' => -1,
		'post_status' => 'publish'
		)
    );
    if ( $items->have_posts() ) : 
        while ( $items->have_posts() ) : $items->the_post();
            if(get_field('geolocalisation_yesno', get_the_ID()) == true) {
                $lat = get_field('latitude', get_the_ID());                
                $lon = get_field('longitude', get_the_ID());
                $titre = get_the_title();
                ?>
                <script>
                    //////////////
                    /// ADD MARKER
                    ///////////
                    var layer = new ol.layer.Vector({
                    source: new ol.source.Vector({
                        features: [
                            new ol.Feature({
                                geometry: new ol.geom.Point(ol.proj.fromLonLat([<?php echo json_encode($lon) ?>, <?php echo json_encode($lat) ?>]))
                            })
                        ]
                    })
                    });
                    map.addLayer(layer);

                    //////////////
                    /// ON CLICK DISPLAY POPUP
                    ///////////
                    map.on('singleclick', function (event) {
                        if (map.hasFeatureAtPixel(event.pixel) === true) {
                            var coordinate = event.coordinate;

                            content.innerHTML = '<b><?php echo json_encode($titre) ?></b><br />I am a popup.';
                            overlay.setPosition(coordinate);
                        } else {
                            overlay.setPosition(undefined);
                            closer.blur();
                        }
                    });
                </script>
                <?php 
            }
        endwhile; 
    endif; 
    wp_reset_query();
?>