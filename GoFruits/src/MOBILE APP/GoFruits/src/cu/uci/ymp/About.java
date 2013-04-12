package cu.uci.ymp;


import android.app.Activity;
import android.os.Bundle;
import android.widget.EditText;


public class About extends Activity {
	
	public void onCreate(Bundle savedInstanceState){
		super.onCreate(savedInstanceState);
		setContentView(R.layout.about);
		EditText text = (EditText)findViewById(R.id.aboutl);
		
	}

}
