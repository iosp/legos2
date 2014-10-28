//****** General functions ***** //

/**
 * Changes the icon of a button an enable it
 * 
 * @param jquerybutton
 * @param newIcon
 */
function activateJqueryButton(jquerybutton, newIcon) {
	if (newIcon == null) {
		newIcon = "plus";
	}
	setJqueryButtonIcon(jquerybutton, newIcon);
	fadeInJqueryButton(jquerybutton);
}

/**
 * Changes the icon of a button an disable it if its not already disabled
 * 
 * @param jquerybutton
 * @param newIcon
 */
function deactivateJqueryButton(jquerybutton, newIcon) {
	if (newIcon == null) {
		newIcon = "check";
	}
	setJqueryButtonIcon(jquerybutton, newIcon);
	// check if the button is already deactivated
	if (jquerybutton.prop("disabled") != true) {
		fadeOutJqueryButton(jquerybutton);
	}
}

/**
 * Fades a button to 40% transparency. Also the property "disabled" is set to
 * "true" and the class "ui-stat-disabled" is added
 * 
 * @param jquerybutton
 */
function fadeOutJqueryButton(jquerybutton) {
	// Set Transparency on the button
	jquerybutton.fadeTo("fast", 0.4);
	// Deactivate Clickable functionality
	jquerybutton.prop("disabled", true).addClass("ui-state-disabled");
}

/**
 * Button is faded in from an transparency to total sight. Also the property
 * "disabled" is set to "false" and the class "ui-stat-disabled" is removed
 * 
 * @param jquerybutton
 */
function fadeInJqueryButton(jquerybutton) {
	// Remove transparency
	jquerybutton.fadeTo("fast", 1);
	// Activate Clickable functionality
	jquerybutton.prop("disabled", false).removeClass("ui-state-disabled");
}

/**
 * Prints Data in div with class log
 * 
 * @param data
 */
function onSuccess(data) {
	jQuery('.log').first().before(data);
	jQuery('.log').first().delay(10000).fadeOut(300);

}

/**
 * Deletes existing icon of an button. Create new icon as in param
 * 
 * @param jquerybutton
 * @param newIcon
 */
function setJqueryButtonIcon(jquerybutton, newIcon) {
	jquerybutton.data("icon", newIcon);
	jquerybutton.find("span .ui-icon").prop("class",
			"ui-icon ui-icon-shadow ui-icon-" + newIcon);
}

// ****** Functions for taxibot/client ***** //

/**
 * Iterates over all buttons with class "ts-ts_*" an deactivates or activates
 * the buttons depending on an index
 * 
 * @param lastSetElement
 * @param sizeofElements
 */
function deactivateTimestamps(lastSetElement, sizeofElements) {
	if (lastSetElement == "" || lastSetElement == null) {
		lastSetElement = 0;
	}
	var nextElement = parseInt(lastSetElement) + 1;
	for ( var i = 1; i <= sizeofElements; i++) {
		if (i < nextElement) {
			deactivateJqueryButton(jQuery("a.ts-ts_" + i + ""), "check");
		} else if (i > nextElement) {
			deactivateJqueryButton(jQuery("a.ts-ts_" + i + ""), "plus");
		} else // if ( i == nextElement )
		{
			activateJqueryButton(jQuery("a.ts-ts_" + i + ""));
		}
	}
}
