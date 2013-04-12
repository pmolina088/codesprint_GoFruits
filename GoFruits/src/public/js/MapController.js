var map, layer;
function init(){
    //    var map, layer;
    map = new OpenLayers.Map('map');
    layer = new OpenLayers.Layer.WMS( "OpenLayers WMS", 
        "http://vmap0.tiles.osgeo.org/wms/vmap0", {
            layers: 'basic'
        } );

    map.addLayer(layer);
    
    //var newl = new OpenLayers.Layer.Text( "text", {location: "textfile.txt"} );
    //			 var newl = new OpenLayers.Layer.Text( "text", {location: "textfile.txt"} );
    //            map.addLayer(newl);
    map.setCenter(new OpenLayers.LonLat(-77.297508, 18.109581), 8);
    map.addControl(new OpenLayers.Control.LayerSwitcher());

}

/**
 *  id	{String} a unqiue identifier for this popup.  If null is passed an identifier will be automatically generated.
    lonlat	{OpenLayers.LonLat} The position on the map the popup will be shown.
    contentSize	{OpenLayers.Size} The size of the content.
    contentHTML	{String} An HTML string to display inside the popup.
    closeBox	{Boolean} Whether to display a close box inside the popup.
    closeBoxCallback	{Function} Function to be called on closeBox click.
 */
function addPoput(id,lon,lat,contentSize,contentHTML,closeBox){
    popup = new OpenLayers.Popup(id,
        new OpenLayers.LonLat(lon,lat),
        new OpenLayers.Size(contentSize,contentSize),
        contentHTML,
        closeBox);

    map.addPopup(popup);
}

function addVector(lon, lat, src){
    var vectorLayer = new OpenLayers.Layer.Vector("Overlay");
    var feature = new OpenLayers.Feature.Vector(
        new OpenLayers.Geometry.Point(lon, lat),
        {
            some:'data'
        },

        {
            externalGraphic: src, 
            graphicHeight: 21, 
            graphicWidth: 16
        });
    vectorLayer.addFeatures(feature);
    map.addLayer(vectorLayer);   
}
