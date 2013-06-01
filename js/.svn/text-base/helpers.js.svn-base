function showWarning(message) {
	showMessage(message, 'warning');
}

function showNotification(message) {
	showMessage(message, null);
}

function showSuccess(message) {
    
        showMessage(message, 'success');
    
}

function showMessage(message, classToUse) {
	var options = { message: message };
	if (classToUse != null) options.useClass = classToUse;
	$.bar(options);
}