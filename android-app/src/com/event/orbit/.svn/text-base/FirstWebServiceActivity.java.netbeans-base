package com.event.orbit;

import java.io.IOException;
import java.net.SocketTimeoutException;
import java.util.ArrayList;
import java.util.Iterator;
import java.util.List;

import org.ksoap2.SoapEnvelope;
import org.ksoap2.serialization.SoapObject;
import org.ksoap2.serialization.SoapSerializationEnvelope;
import org.ksoap2.transport.HttpTransportSE;
import org.xmlpull.v1.XmlPullParserException;

import android.app.ListActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.thoughtworks.xstream.XStream;

public class FirstWebServiceActivity extends ListActivity  {

	private static final String NAMESPACE = "urn:MobileAppControllerwsdl";
	private static final String URL = "http://10.0.2.2:8888/eventorbit/mobileapp/mobile?ws=1";
	private static final String SOAP_ACTION = "urn:MobileAppControllerwsdl#getEvents";
	private static final String METHOD_NAME = "getEvents";

	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		

		SoapSerializationEnvelope envelope = new SoapSerializationEnvelope(
				SoapEnvelope.VER11);

		SoapObject request = new SoapObject("urn:MobileAppControllerwsdl",
				"getEvents");

		//request.addProperty("name", 7);
		envelope.setOutputSoapObject(request);
		envelope.dotNet = false;
		HttpTransportSE androidHttpTransport = new HttpTransportSE(URL,60000);
		
		androidHttpTransport.debug = true;

		envelope.encodingStyle = SoapSerializationEnvelope.ENC;
		envelope.xsd = SoapSerializationEnvelope.XSD;
		envelope.enc = SoapSerializationEnvelope.ENC;

		// androidHttpTransport.setXmlVersionTag("<?xml version=\"1.0\" encoding=\"utf-8\"?>");
		envelope.setBodyOutEmpty(false);
		envelope.setAddAdornments(false);
		envelope.implicitTypes = false;

		try {
			androidHttpTransport.call("", envelope);
		} catch (SocketTimeoutException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch (XmlPullParserException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}

		SoapObject resultsRequestSOAP = (SoapObject) envelope.bodyIn;
		String value = (String) resultsRequestSOAP.getProperty(0).toString();
		System.out.println(value);
		XStream xstream = new XStream();
		xstream.alias("Business", Business.class);
		xstream.alias("EventList", Events.class);
		xstream.alias("Event", EventInfo.class);
		xstream.addImplicitCollection(Events.class, "Event");
		Business business = (Business)xstream.fromXML(value);
		
		List<String> myList = new ArrayList<String>();
		for (Iterator iterator = business.getBusiness().getEvent().iterator(); iterator.hasNext();) {
			EventInfo eventInfo = (EventInfo) iterator.next();
			myList.add(eventInfo.getName());
		}

		setListAdapter(new ArrayAdapter<String>(this, R.layout.list_item, myList));

		  ListView lv = getListView();
		  lv.setTextFilterEnabled(true);

		  lv.setOnItemClickListener(new OnItemClickListener() {
		    public void onItemClick(AdapterView<?> parent, View view,
		        int position, long id) {
		      // When clicked, show a toast with the TextView text
		      Toast.makeText(getApplicationContext(), ((TextView) view).getText(),
		          Toast.LENGTH_SHORT).show();
		    }
		  });
	} // end callWebService()

	// }
}