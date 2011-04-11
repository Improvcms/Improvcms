$(document).ready(function(){
/*
	MillionCMS Project
    
    Name: mCMS Javascript File
    Description: Animation's and Notification's
    Author: Damian Sharpe

    Copyright � 2010 Damian and the MillionCMS Group
        All Rights Reserved

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option') any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

// Notification Close Button
	$(".close").click(
		function () {
			$(this).parent().fadeTo(400, 0, function () {
				$(this).slideUp(400);
			});
			return false;
		}
	);

// Alternating Table Rows		
	$('tbody tr:even').addClass("alt-row");
	
});