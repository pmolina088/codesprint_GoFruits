package cu.uci.ymp;

import java.io.File;
import java.io.FileOutputStream;
import java.io.InputStream;

import org.mapsforge.android.maps.MapActivity;
import org.mapsforge.android.maps.MapView;
import org.mapsforge.android.maps.overlay.ArrayItemizedOverlay;
import org.mapsforge.core.GeoPoint;
import android.content.Intent;
import android.content.res.AssetManager;
import android.graphics.drawable.Drawable;
import android.os.Bundle;
import android.os.Environment;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.LinearLayout;

public class MyMapActivity extends MapActivity {
	
	
	LinearLayout searchPanel;
	Button searchButton;
	EditText searchText;
	
	public void onCreate(Bundle savedInstanceState){
		super.onCreate(savedInstanceState);
		setContentView(R.layout.main);
		MapView mapView = (MapView)findViewById(R.id.my_map);
				//new MapView(this);
				
		
		searchPanel = (LinearLayout)findViewById(R.id.searchPanel);
		searchButton = (Button) findViewById(R.id.searchButton);
		searchText = (EditText) findViewById(R.id.searchText);
		
		mapView.setClickable(true);
		mapView.setBuiltInZoomControls(true);
		
		
		mapView.setCenter(new GeoPoint(18.109581, -77.297508));
		mapView.getController().setZoom(10);
		this.uploadMap();
		mapView.setMapFile(new File("/sdcard/maps/jamaica.map"));
		
		Drawable defaultMarker = getResources().getDrawable(R.drawable.marker);
		ArrayItemizedOverlay itemizedOverlay = new ArrayItemizedOverlay(defaultMarker);
		GeoPoint point = new GeoPoint(18.109581, -77.297508);
		org.mapsforge.android.maps.overlay.OverlayItem item = new org.mapsforge.android.maps.overlay.OverlayItem(point, "Gofruits", "Starting point to find the best crops land in Jamaica");
		itemizedOverlay.addItem(item);
		mapView.getOverlays().add(itemizedOverlay);
		
		
	}
	
	public void uploadMap(){
		AssetManager asset = getAssets();
		try{
			File dir = new File(Environment.getExternalStorageDirectory() + "/maps/");
			if(!dir.exists()){
				dir.mkdir();
			}
			
		String fileName = "jamaica.map";
		File destinationFile = new File(Environment.getExternalStorageDirectory() + "/maps/" + fileName);
		if(!destinationFile.exists()){
			
			InputStream in = asset.open("jamaica.map");
			FileOutputStream f = new FileOutputStream(destinationFile);
			byte[] buffer = new byte[1024];
			int len1 = 0;
			
			while((len1 = in.read(buffer)) > 0){
				f.write(buffer, 0, len1);
			}
			f.close();
		}
			
		}
		catch(Exception e){
			Log.e("CopyFileFromAssetsToSD", e.getMessage());
		}
		
		
	}
	
	//LinearLayout searchPanel;
	public static final int SEARCH_ID = Menu.FIRST;
	@Override
	public boolean onCreateOptionsMenu(Menu menu){
		boolean result = super.onCreateOptionsMenu(menu);
		menu.add(0, SEARCH_ID, 0, "Search");
		return result;
		
	}
	
	public boolean onOptionsItemsSelected(MenuItem item){
		boolean result = super.onOptionsItemSelected(item);
		
	switch(item.getItemId()){	
	case SEARCH_ID:
			searchPanel.setVisibility(View.VISIBLE);
			break;
	case R.id.aboutl:
		startActivity(new Intent(this, About.class));
		return true;
		default:
			return super.onOptionsItemSelected(item);
		
		}
	return result;
	
	}
	

}

























