$(document).ready(function(){
/*
	MillionCMS Project
    
    Name: mCMS Javascript File
    Description: Random Image Generator for ACP Login...
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

	function randImg() {
	var links= new Array(3);
	links[0]='wine.jpg';
	links[1]='whisky.jpg';
	links[2]='beer.jpg';
	var ran_unrounded=Math.random()*2;
	var rand=Math.round(ran_unrounded);
	var image= links[rand];
	var imagehtml='<img src="'+image+'" alt="'+image.replace(/.jpg/, "")+'" />';
	p = document.getElementById('rand-img');
	if (p) {
	 range = document.createRange();
	 range.setStartBefore(p);
	 p.appendChild(range.createContextualFragment(imagehtml));
	 }
	}
	
	window.onload=randImg;
});