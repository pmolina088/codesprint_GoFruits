package cu.uci.ymp;



import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.Button;

public class GoFruitsWebsite extends Activity {
	 public void onCreate(Bundle savedInstanceState) {
	        super.onCreate(savedInstanceState);
	        setContentView(R.layout.web_view);
	        
	        WebView myWebView = (WebView) findViewById(R.id.webview);
	        
	        //loading web settings
	        WebSettings webSet = myWebView.getSettings();
	        webSet.setJavaScriptEnabled(true);
	        webSet.setGeolocationEnabled(true);
	        webSet.setUserAgentString("Android 4.0");
	        webSet.setAppCacheEnabled(false);
	        
	        //super importante sin esto no va a funncionar
	        WebView.enablePlatformNotifications();
	        
	        //setting the web client
	        myWebView.setWebViewClient(new WebViewClient());
	        //showing the webview
	        myWebView.loadUrl("http://192.168.187.1:5501/");
	        Button seeMapButton = (Button)findViewById(R.id.mapButton);
	        seeMapButton.setOnClickListener(new View.OnClickListener() {
				
				public void onClick(View view) {
					// TODO Auto-generated method stub
					startActivity(new Intent(view.getContext(), MyMapActivity.class));
				}
			});
	        
	        Button aboutButton = (Button)findViewById(R.id.aboutButton);
	        aboutButton.setOnClickListener(new View.OnClickListener() {
				
				public void onClick(View v) {
					startActivity(new Intent(v.getContext(), About.class));
					
				}
			});
	      
	        
	        
	       
	    }

}
