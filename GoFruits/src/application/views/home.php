<!-- Main hero unit for a primary marketing message or call to action -->
<div class="container-map">
    <div class="row-fluid">
        <div class="span9">
            <div id="map" class="smallmap olMap"></div>
        </div>
        <div class="span3">
            <p class="help-block">Find some crop by name here...</p>
            <input id="crops" type="text" data-provide="typeahead" autocomplete="off">

            <script type="text/javascript">
                $(function () {
                    $('#crops').typeahead({
                        source : [<?php echo implode(',', $crop_types); ?>],
                        updater: function (item) {
                            getCrops(item);
                            return item;
                        }
                    });

                    function getCrops(item) {

                        // la variable map contiene el mapa
                        var markers = new OpenLayers.Layer.Markers( "Markers" );
                        map.addLayer(markers);

                        $.ajax({
                            type: "POST",
                            url: 'welcome/getCropsByName',
                            data: { 'name' : item },
                            dataType: 'json',
                            success: function (data) {

                                $.each(data, function (index, element) {
                                    //console.log(element);

                                    var size = new OpenLayers.Size(18, 25);
                                    var offset = new OpenLayers.Pixel(-(size.w/2), -size.h);
                                    var icon = new OpenLayers.Icon('<?=base_url()?>public/img/marker.png', size, offset);

                                    markers.addMarker(new OpenLayers.Marker(new OpenLayers.LonLat(element.Xcoord, element.Ycoord),icon));
                                    markers.addMarker(new OpenLayers.Marker(new OpenLayers.LonLat(element.Xcoord, element.Ycoord),icon.clone()));
                                });

                            },
                            error: function (jqXHR, texterror) {
                                alert("Tha data couldn't be loaded");
                            }
                        });
                    }
                });
            </script>
        </div>
    </div>
    <!--/.hero-unit-->
</div>

<!-- Example row of columns -->
<div class="row-fluid">
    <div class="span4">
        <h2>Jamaican agriculture</h2>

        <p>
            Agricultural production is an important contributor to Jamaica's economy, accounting for 7.4 percent of GDP in 1997 and providing nearly a quarter of the country's employment. Sugar, which has been produced in Jamaica for centuries, is the nation's dominant agricultural export, but the country also produces bananas, coffee, spices, pimentos, cocoa, citrus, and coconuts. In addition to legal agricultural production, Jamaica is also a major producer of marijuana, known locally as ganja , which contributes a great deal of money to the informal economy . Agricultural production of all sorts has been subject to the region's tumultuous weather, which includes seasonal hurricanes and occasional drought. In addition to cash crops , Jamaica also produces a wide variety of produce for domestic consumption.
        </p>

        <p><a class="btn" href="#">View details &raquo;</a></p>
    </div>

    <div class="span4">
        <h2>Jamaican fruits</h2>

        <p>
            If you explore Jamaican fruits, you'll soon discover that we have many that are international staples - banana, pineapple, papaya (we call it paw-paw), various types of melons. But there is a whole host of Jamaican fruit that you might not comeacross in your every day runnings. These are the ones I'll tell you a little bit about on this page. Of course, I can only describe them in words and pictures - the taste and the smell are another matter entirely.
        </p>

        <p><a class="btn" href="#">View details &raquo;</a></p>
    </div>

    <div class="span4">
        <h2>Jamaican culture</h2>

        <p>
            Much imitated, in-your-face-overstated, never to be underrated, Jamaican culture has become known and loved all over the world. There are Japanese sporting dreadlocks, Germans singing reggae, Koreans selling jerk chicken, and Americans (mostly unsuccessfully) trying to talk like Jamaicans!
Here you can find the best fruits and vegetables producers and crops by experienced and location.
        </p>

        <p><a class="btn" href="#">View details &raquo;</a></p>
    </div>
</div>