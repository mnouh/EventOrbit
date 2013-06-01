/**
 * 
 */
package com.event.orbit;

import com.thoughtworks.xstream.annotations.XStreamAlias;


/**
 * @author siddhu
 *
 */
@XStreamAlias("Business")
public class Business {

	@XStreamAlias("EventList")
	Events EventList;

	public Events getBusiness() {
		return EventList;
	}

	public void setBusiness(Events business) {
		EventList = business;
	}

	
	
}
