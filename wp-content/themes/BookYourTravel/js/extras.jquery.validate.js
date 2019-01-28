(function($) { // Hide the namespace
	/* Add validation methods if validation plugin available. */
	if ($.fn.validate) {
		
		$.extend($.datepicker.regional[''], {
			validateDate: 'Please enter a valid date',
			validateDateMin: 'Please enter a date on or after {0}',
			validateDateMax: 'Please enter a date on or before {0}',
			validateDateMinMax: 'Please enter a date between {0} and {1}',
			validateDateCompare: 'Please enter a date {0} {1}'
		});		
		$.extend($.datepicker._defaults, $.datepicker.regional['']);		
		
		$.extend($.datepicker, {		
			errorFormat: function(inst, message, params) {
				var format = $.datepicker._get(inst, 'dateFormat');
				$.each(params, function(i, v) {
					if (message) {
						message = message.replace(new RegExp('\\{' + i + '\\}', 'g'),
							$.datepicker.formatDate(format, v) || 'nothing');
					}
				});
				return message;
			}
		});
		
		jQuery.validator.addMethod("dateFormatDate", function(value, element, params){
			lastElement = element;
			var inst = $.datepicker._getInst(element);
			
			try {
				var date = $.datepicker.parseDate(window.datepickerDateFormat, value, $.datepicker._getFormatConfig(inst));
				var minDate = $.datepicker._determineDate(inst, $.datepicker._get(inst, 'minDate'), null);
				var maxDate = $.datepicker._determineDate(inst, $.datepicker._get(inst, 'maxDate'), null);
				var beforeShowDay = $.datepicker._get(inst, 'beforeShowDay');
				return this.optional(element) || !date || 
					((!minDate || date >= minDate) && (!maxDate || date <= maxDate) &&
					(!beforeShowDay || beforeShowDay.apply(element, [date])[0]));
			}
			catch (e) {
				return false;
			}
			
		}, function(params) {
			var inst = $.datepicker._getInst(lastElement);
			var minDate = $.datepicker._determineDate(inst, $.datepicker._get(inst, 'minDate'), null);
			var maxDate = $.datepicker._determineDate(inst, $.datepicker._get(inst, 'maxDate'), null);
			var messages = $.datepicker._defaults;
			return (minDate && maxDate ?
				$.datepicker.errorFormat(inst, messages.validateDateMinMax, [minDate, maxDate]) :
				(minDate ? $.datepicker.errorFormat(inst, messages.validateDateMin, [minDate]) :
				(maxDate ? $.datepicker.errorFormat(inst, messages.validateDateMax, [maxDate]) :
				messages.validateDate)));
		});
		
		/* And allow as a class rule. */
		$.validator.addClassRules('dateFormatDate', {dateFormatDate: true});
		
	}

})(jQuery);