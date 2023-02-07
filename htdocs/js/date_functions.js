// JavaScript Document
//
// date_functions.js
//
// AUTHOR: Greg Parkin
//
// var today = new Date();
// today.toMMDDYYYY();                   Format: 03/10/2013
// today.toWeekdayMonthDayYear();        Format: Sunday, March 10, 2013
// var julian = today.Date2Julian();
// var yesterday = new Date('4-July-2000');
// var days = today.getDaysBetween(yesterday);
// var tomorrow = AddDays(today, 1);
// var mdays = daysInMonth(today);       Returns the number of days in the month (date can be any date in the month)
// var mdays = today.monthDays();        Returns the number of days in the month
//

Date.prototype.toMMDDYYYY = function()
{
	var padNumber = function(number)
	{
		number = number.toString();
		if (number.length === 1)
		{
			return "0" + number;
		}
		return number;
	};
	return padNumber(this.getMonth() + 1) + "/" + padNumber(this.getDate()) + "/" + this.getFullYear();
};

Date.prototype.toWeekdayMonthDayYear = function()
{
	var month;
	var weekday;
	
	switch ( this.getMonth() + 1 )
	{
	case 1:  month = "January"; break;
	case 2:  month = "February"; break;
	case 3:  month = "March"; break;
	case 4:  month = "April"; break;
	case 5:  month = "May"; break;
	case 6:  month = "June"; break;
	case 7:  month = "July"; break;
	case 8:  month = "August"; break;
	case 9:  month = "September"; break;
	case 10: month = "October"; break;
	case 11: month = "November"; break;
	case 12: month = "December"; break;
	default: month = "Unknown"; break;
	}
	
	switch ( this.getDay() )
	{
	case 0: weekday = "Sunday"; break;
	case 1: weekday = "Monday"; break;
	case 2: weekday = "Tuesday"; break;
	case 3: weekday = "Wednesday"; break;
	case 4: weekday = "Thursday"; break;
	case 5: weekday = "Friday"; break;
	case 6: weekday = "Saturday"; break;
	}
	
	return weekday + ", " + month + " " + this.getDate() + ", " + this.getFullYear();
};

Date.prototype.Date2Julian = function()
{
	return Math.floor((this / 86400000) - (this.getTimezoneOffset()/1440) + 2440587.5);
};

Date.prototype.copy = function()
{
	return new Date(this.getTime());
};

Date.prototype.msPERDAY = 1000 * 60 * 60 * 24;

Date.prototype.getDaysBetween = function(d)
{
	d = d.copy();
	
	d.setHours(this.getHours(), this.getMinutes(), this.getSeconds(), this.getMilliseconds());
	
	var diff = d.getTime() - this.getTime();
	return (diff) / this.msPERDAY;
};

Date.prototype.monthDays = function()
{
	var d = new Date(this.getFullYear(), this.getMonth()+1, 0);
	return d.getDate();
};

Date.prototype.Julian2Date = function()
{
	var X = parseFloat(this)+0.5;
	var Z = Math.floor(X);  // Get day without time
	var F = X - Z;  // Get time
	var Y = Math.floor((Z-1867216.25)/36524.25);
	var A = Z+1+Y-Math.floor(Y/4);
	var B = A+1524;
	var C = Math.floor((B-122.1)/365.25);
	var D = Math.floor(365.25*C);
	var G = Math.floor((B-D)/30.6001);
	
	var month = (G<13.5) ? (G-1) : (G-13); // must get number less than or equal to 12
	var year = (month<2.5) ? (C-4715) : (C-4716); // if Month is January or February, or the rest of year
	month -= 1; //Handle JavaScript month format
	var UT = B-D-Math.floor(30.6001*G)+F;
	var day = Math.floor(UT);
	
	// Determine time
	UT -= Math.floor(UT);
	UT *= 24;
	var hour = Math.floor(UT);
	UT -= Math.floor(UT);
	UT *= 60;
	var minute = Math.floor(UT);
	UT -= Math.floor(UT);
	UT *= 60;
	var second = Math.round(UT);
	
	return new Date(Date.UTC(year, month, day, hour, minute, second));
};

function AddDays(myDate, days)
{
	return new Date(myDate.getTime() + days*24*60*60*1000);
}

function SubDays(myDate, days)
{
	return new Date(myDate.getTime() - days*24*60*60*1000);
}

function daysInMonth(anyDateInMonth)
{
	return new Date(anyDateInMonth.getYear(), ++anyDateInMonth.getMonth(), 0).getDate();
}

