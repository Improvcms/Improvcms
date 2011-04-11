<?php
/*
MillionCMS Project
    
    Name: Installer
    Description: Main Installer File

    Author: Kieran D, Gaara

    Copyright © 2010 Gaara, Kieran D and MillionCMS Group
	All Rights Reserved

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once("./resources/functions.php");
error_reporting(0);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
	<link rel="stylesheet" type="text/css" href="./style.css" media="screen" />
	<title>MillionCMS Install</title>
</head>
<body>

   <div id="wrapper">
   
		<div id="header">
			<img src="../images/logo.png" alt="MillionCMS Installer" />		 
		</div>
		
		<?php
		$action = $_REQUEST['action'];	 

		if(file_exists('lock'))
		{
			$action = "locked";
		}
		
		switch ($action)
		{
			case 'licence':			
			echo "<div id='navigation'>Overview - <b>Licence</b> - DB Details - Creating Admin - Settings - Admin Details - Finish</div>";			
			echo "<div id='content'>";
			licence();
			break;			
			
			case 'database':			
			echo "<div id='navigation'>Overview - Licence - <b>DB Details</b> - Creating Admin - Settings - Admin Details - Finish</div>";			
			echo "<div id='content'>";
			database();
			break;		
			
			case 'do_database':			
			echo "<div id='navigation'>Overview - Licence - <b>DB Details</b> - Settings - Admin Details - Finish</div>";			
			echo "<div id='content'>";
			do_database();
			break;
			
			case 'do_database_admin':			
			echo "<div id='navigation'>Overview - Licence - DB Details - <b>Creating Admin</b> - Settings - Admin Details - Finish</div>";			
			echo "<div id='content'>";
			do_database_admin();
			break;
			
			case 'settings':			
			echo "<div id='navigation'>Overview - Licence - DB Details - <b>Settings</b> - Admin Details - Finish</div>";			
			echo "<div id='content'>";
			settings();
			break;
			
			case 'do_settings':			
			echo "<div id='navigation'>Overview - Licence - DB Details - <b>Settings</b> - Admin Details - Finish</div>";			
			echo "<div id='content'>";
			do_settings();
			break;
			
			case 'admin':			
			echo "<div id='navigation'>Overview - Licence - DB Details - Settings - <b>Admin Details</b> - Finish</div>";			
			echo "<div id='content'>";
			admin();
			break;
			
			case 'do_admin':			
			echo "<div id='navigation'>Overview - Licence - DB Details - Settings - <b>Admin Details</b> - Finish</div>";			
			echo "<div id='content'>";
			do_admin();
			break;
			
			case 'finish':			
			echo "<div id='navigation'>Overview - Licence - DB Details - Settings - Admin Details - <b>Finish</b></div>";			
			echo "<div id='content'>";
			finish();
			break;	
			
			case 'locked':
			echo "<div id='navigation'><b>Error - Installer Locked</b></div>";			
			echo "<div id='content'>";
			locked();
			break;
			
			default:			
			echo "<div id='navigation'><b>Overview</b> - Licence - DB Details - Settings - Admin Details - Finish</div>";			
			echo "<div id='content'>";
			overview();
			break;
		}
		
		function overview()
		{
			$nextpage = "licence";
			
			//Welcome Text
			echo "<p>Welcome to your MillionCMS installation. This wizard will guide you through the license agreement, database configuration and creation of an administrator account.
			<br /><br />We hope you enjoy this software and remember if you ever have any problems with it feel free to submit it to the 
			<a href='http://millioncms.com/forums'>General Support Board</a>. <br />Also remember as this is a Alpha release please submit any bugs
			you find to the <a href='http://dev.millioncms.com/projects/millioncms/issues'>MillionCMS Bug Tracker.</a>.<br /><br />";	
			
			//Installation Overview
			echo "Below is an outline of what will happen during this installation:
			<ul>
			<li>MillionCMS Licence Agreement</li>
			<li>Requirements Check</li>
			<li>Configuration of database and creation of database tables</li>
			<li>Creation of an administrator account to manage the ideas</li>
			</ul>
			After each step has successfully been completed, click Next to move on to the next step.";		
			
			//Next Button
			echo "<br />Click 'Next' to view the MillionCMS Licence and start the install.</p><br />
			<form method='POST' action='./index.php'>
			<input type='hidden' name='action' value='{$nextpage}' />
			<input type='submit' value='Next' />
			</form>";
		}		
		
		function licence()
		{
			$nextpage = "database";		
			
			//Licence Intro
			echo "MillionCMS is released under the GNU General Public License v3 (GNU GPLv3) as shown below:<br />";
			
			//Licence Text
			echo "<br /><div id='licence'><pre>";
			echo "                    GNU GENERAL PUBLIC LICENSE
                       Version 3, 29 June 2007

 Copyright (C) 2007 Free Software Foundation, Inc. <http://fsf.org/>
 Everyone is permitted to copy and distribute verbatim copies
 of this license document, but changing it is not allowed.

                            Preamble

  The GNU General Public License is a free, copyleft license for
software and other kinds of works.

  The licenses for most software and other practical works are designed
to take away your freedom to share and change the works.  By contrast,
the GNU General Public License is intended to guarantee your freedom to
share and change all versions of a program--to make sure it remains free
software for all its users.  We, the Free Software Foundation, use the
GNU General Public License for most of our software; it applies also to
any other work released this way by its authors.  You can apply it to
your programs, too.

  When we speak of free software, we are referring to freedom, not
price.  Our General Public Licenses are designed to make sure that you
have the freedom to distribute copies of free software (and charge for
them if you wish), that you receive source code or can get it if you
want it, that you can change the software or use pieces of it in new
free programs, and that you know you can do these things.

  To protect your rights, we need to prevent others from denying you
these rights or asking you to surrender the rights.  Therefore, you have
certain responsibilities if you distribute copies of the software, or if
you modify it: responsibilities to respect the freedom of others.

  For example, if you distribute copies of such a program, whether
gratis or for a fee, you must pass on to the recipients the same
freedoms that you received.  You must make sure that they, too, receive
or can get the source code.  And you must show them these terms so they
know their rights.

  Developers that use the GNU GPL protect your rights with two steps:
(1) assert copyright on the software, and (2) offer you this License
giving you legal permission to copy, distribute and/or modify it.

  For the developers' and authors' protection, the GPL clearly explains
that there is no warranty for this free software.  For both users' and
authors' sake, the GPL requires that modified versions be marked as
changed, so that their problems will not be attributed erroneously to
authors of previous versions.

  Some devices are designed to deny users access to install or run
modified versions of the software inside them, although the manufacturer
can do so.  This is fundamentally incompatible with the aim of
protecting users' freedom to change the software.  The systematic
pattern of such abuse occurs in the area of products for individuals to
use, which is precisely where it is most unacceptable.  Therefore, we
have designed this version of the GPL to prohibit the practice for those
products.  If such problems arise substantially in other domains, we
stand ready to extend this provision to those domains in future versions
of the GPL, as needed to protect the freedom of users.

  Finally, every program is threatened constantly by software patents.
States should not allow patents to restrict development and use of
software on general-purpose computers, but in those that do, we wish to
avoid the special danger that patents applied to a free program could
make it effectively proprietary.  To prevent this, the GPL assures that
patents cannot be used to render the program non-free.

  The precise terms and conditions for copying, distribution and
modification follow.

                       TERMS AND CONDITIONS

  0. Definitions.

  'This License' refers to version 3 of the GNU General Public License.

  'Copyright' also means copyright-like laws that apply to other kinds of
works, such as semiconductor masks.

  'The Program' refers to any copyrightable work licensed under this
License.  Each licensee is addressed as 'you'.  'Licensees' and
'recipients' may be individuals or organizations.

  To 'modify' a work means to copy from or adapt all or part of the work
in a fashion requiring copyright permission, other than the making of an
exact copy.  The resulting work is called a 'modified version' of the
earlier work or a work 'based on' the earlier work.

  A 'covered work' means either the unmodified Program or a work based
on the Program.

  To 'propagate' a work means to do anything with it that, without
permission, would make you directly or secondarily liable for
infringement under applicable copyright law, except executing it on a
computer or modifying a private copy.  Propagation includes copying,
distribution (with or without modification), making available to the
public, and in some countries other activities as well.

  To 'convey' a work means any kind of propagation that enables other
parties to make or receive copies.  Mere interaction with a user through
a computer network, with no transfer of a copy, is not conveying.

  An interactive user interface displays 'Appropriate Legal Notices'
to the extent that it includes a convenient and prominently visible
feature that (1) displays an appropriate copyright notice, and (2)
tells the user that there is no warranty for the work (except to the
extent that warranties are provided), that licensees may convey the
work under this License, and how to view a copy of this License.  If
the interface presents a list of user commands or options, such as a
menu, a prominent item in the list meets this criterion.

  1. Source Code.

  The 'source code' for a work means the preferred form of the work
for making modifications to it.  'Object code' means any non-source
form of a work.

  A 'Standard Interface' means an interface that either is an official
standard defined by a recognized standards body, or, in the case of
interfaces specified for a particular programming language, one that
is widely used among developers working in that language.

  The 'System Libraries' of an executable work include anything, other
than the work as a whole, that (a) is included in the normal form of
packaging a Major Component, but which is not part of that Major
Component, and (b) serves only to enable use of the work with that
Major Component, or to implement a Standard Interface for which an
implementation is available to the public in source code form.  A
'Major Component', in this context, means a major essential component
(kernel, window system, and so on) of the specific operating system
(if any) on which the executable work runs, or a compiler used to
produce the work, or an object code interpreter used to run it.

  The 'Corresponding Source' for a work in object code form means all
the source code needed to generate, install, and (for an executable
work) run the object code and to modify the work, including scripts to
control those activities.  However, it does not include the work's
System Libraries, or general-purpose tools or generally available free
programs which are used unmodified in performing those activities but
which are not part of the work.  For example, Corresponding Source
includes interface definition files associated with source files for
the work, and the source code for shared libraries and dynamically
linked subprograms that the work is specifically designed to require,
such as by intimate data communication or control flow between those
subprograms and other parts of the work.

  The Corresponding Source need not include anything that users
can regenerate automatically from other parts of the Corresponding
Source.

  The Corresponding Source for a work in source code form is that
same work.

  2. Basic Permissions.

  All rights granted under this License are granted for the term of
copyright on the Program, and are irrevocable provided the stated
conditions are met.  This License explicitly affirms your unlimited
permission to run the unmodified Program.  The output from running a
covered work is covered by this License only if the output, given its
content, constitutes a covered work.  This License acknowledges your
rights of fair use or other equivalent, as provided by copyright law.

  You may make, run and propagate covered works that you do not
convey, without conditions so long as your license otherwise remains
in force.  You may convey covered works to others for the sole purpose
of having them make modifications exclusively for you, or provide you
with facilities for running those works, provided that you comply with
the terms of this License in conveying all material for which you do
not control copyright.  Those thus making or running the covered works
for you must do so exclusively on your behalf, under your direction
and control, on terms that prohibit them from making any copies of
your copyrighted material outside their relationship with you.

  Conveying under any other circumstances is permitted solely under
the conditions stated below.  Sublicensing is not allowed; section 10
makes it unnecessary.

  3. Protecting Users' Legal Rights From Anti-Circumvention Law.

  No covered work shall be deemed part of an effective technological
measure under any applicable law fulfilling obligations under article
11 of the WIPO copyright treaty adopted on 20 December 1996, or
similar laws prohibiting or restricting circumvention of such
measures.

  When you convey a covered work, you waive any legal power to forbid
circumvention of technological measures to the extent such circumvention
is effected by exercising rights under this License with respect to
the covered work, and you disclaim any intention to limit operation or
modification of the work as a means of enforcing, against the work's
users, your or third parties' legal rights to forbid circumvention of
technological measures.

  4. Conveying Verbatim Copies.

  You may convey verbatim copies of the Program's source code as you
receive it, in any medium, provided that you conspicuously and
appropriately publish on each copy an appropriate copyright notice;
keep intact all notices stating that this License and any
non-permissive terms added in accord with section 7 apply to the code;
keep intact all notices of the absence of any warranty; and give all
recipients a copy of this License along with the Program.

  You may charge any price or no price for each copy that you convey,
and you may offer support or warranty protection for a fee.

  5. Conveying Modified Source Versions.

  You may convey a work based on the Program, or the modifications to
produce it from the Program, in the form of source code under the
terms of section 4, provided that you also meet all of these conditions:

    a) The work must carry prominent notices stating that you modified
    it, and giving a relevant date.

    b) The work must carry prominent notices stating that it is
    released under this License and any conditions added under section
    7.  This requirement modifies the requirement in section 4 to
    'keep intact all notices'.

    c) You must license the entire work, as a whole, under this
    License to anyone who comes into possession of a copy.  This
    License will therefore apply, along with any applicable section 7
    additional terms, to the whole of the work, and all its parts,
    regardless of how they are packaged.  This License gives no
    permission to license the work in any other way, but it does not
    invalidate such permission if you have separately received it.

    d) If the work has interactive user interfaces, each must display
    Appropriate Legal Notices; however, if the Program has interactive
    interfaces that do not display Appropriate Legal Notices, your
    work need not make them do so.

  A compilation of a covered work with other separate and independent
works, which are not by their nature extensions of the covered work,
and which are not combined with it such as to form a larger program,
in or on a volume of a storage or distribution medium, is called an
'aggregate' if the compilation and its resulting copyright are not
used to limit the access or legal rights of the compilation's users
beyond what the individual works permit.  Inclusion of a covered work
in an aggregate does not cause this License to apply to the other
parts of the aggregate.

  6. Conveying Non-Source Forms.

  You may convey a covered work in object code form under the terms
of sections 4 and 5, provided that you also convey the
machine-readable Corresponding Source under the terms of this License,
in one of these ways:

    a) Convey the object code in, or embodied in, a physical product
    (including a physical distribution medium), accompanied by the
    Corresponding Source fixed on a durable physical medium
    customarily used for software interchange.

    b) Convey the object code in, or embodied in, a physical product
    (including a physical distribution medium), accompanied by a
    written offer, valid for at least three years and valid for as
    long as you offer spare parts or customer support for that product
    model, to give anyone who possesses the object code either (1) a
    copy of the Corresponding Source for all the software in the
    product that is covered by this License, on a durable physical
    medium customarily used for software interchange, for a price no
    more than your reasonable cost of physically performing this
    conveying of source, or (2) access to copy the
    Corresponding Source from a network server at no charge.

    c) Convey individual copies of the object code with a copy of the
    written offer to provide the Corresponding Source.  This
    alternative is allowed only occasionally and noncommercially, and
    only if you received the object code with such an offer, in accord
    with subsection 6b.

    d) Convey the object code by offering access from a designated
    place (gratis or for a charge), and offer equivalent access to the
    Corresponding Source in the same way through the same place at no
    further charge.  You need not require recipients to copy the
    Corresponding Source along with the object code.  If the place to
    copy the object code is a network server, the Corresponding Source
    may be on a different server (operated by you or a third party)
    that supports equivalent copying facilities, provided you maintain
    clear directions next to the object code saying where to find the
    Corresponding Source.  Regardless of what server hosts the
    Corresponding Source, you remain obligated to ensure that it is
    available for as long as needed to satisfy these requirements.

    e) Convey the object code using peer-to-peer transmission, provided
    you inform other peers where the object code and Corresponding
    Source of the work are being offered to the general public at no
    charge under subsection 6d.

  A separable portion of the object code, whose source code is excluded
from the Corresponding Source as a System Library, need not be
included in conveying the object code work.

  A 'User Product' is either (1) a 'consumer product', which means any
tangible personal property which is normally used for personal, family,
or household purposes, or (2) anything designed or sold for incorporation
into a dwelling.  In determining whether a product is a consumer product,
doubtful cases shall be resolved in favor of coverage.  For a particular
product received by a particular user, 'normally used' refers to a
typical or common use of that class of product, regardless of the status
of the particular user or of the way in which the particular user
actually uses, or expects or is expected to use, the product.  A product
is a consumer product regardless of whether the product has substantial
commercial, industrial or non-consumer uses, unless such uses represent
the only significant mode of use of the product.

  'Installation Information' for a User Product means any methods,
procedures, authorization keys, or other information required to install
and execute modified versions of a covered work in that User Product from
a modified version of its Corresponding Source.  The information must
suffice to ensure that the continued functioning of the modified object
code is in no case prevented or interfered with solely because
modification has been made.

  If you convey an object code work under this section in, or with, or
specifically for use in, a User Product, and the conveying occurs as
part of a transaction in which the right of possession and use of the
User Product is transferred to the recipient in perpetuity or for a
fixed term (regardless of how the transaction is characterized), the
Corresponding Source conveyed under this section must be accompanied
by the Installation Information.  But this requirement does not apply
if neither you nor any third party retains the ability to install
modified object code on the User Product (for example, the work has
been installed in ROM).

  The requirement to provide Installation Information does not include a
requirement to continue to provide support service, warranty, or updates
for a work that has been modified or installed by the recipient, or for
the User Product in which it has been modified or installed.  Access to a
network may be denied when the modification itself materially and
adversely affects the operation of the network or violates the rules and
protocols for communication across the network.

  Corresponding Source conveyed, and Installation Information provided,
in accord with this section must be in a format that is publicly
documented (and with an implementation available to the public in
source code form), and must require no special password or key for
unpacking, reading or copying.

  7. Additional Terms.

  'Additional permissions' are terms that supplement the terms of this
License by making exceptions from one or more of its conditions.
Additional permissions that are applicable to the entire Program shall
be treated as though they were included in this License, to the extent
that they are valid under applicable law.  If additional permissions
apply only to part of the Program, that part may be used separately
under those permissions, but the entire Program remains governed by
this License without regard to the additional permissions.

  When you convey a copy of a covered work, you may at your option
remove any additional permissions from that copy, or from any part of
it.  (Additional permissions may be written to require their own
removal in certain cases when you modify the work.)  You may place
additional permissions on material, added by you to a covered work,
for which you have or can give appropriate copyright permission.

  Notwithstanding any other provision of this License, for material you
add to a covered work, you may (if authorized by the copyright holders of
that material) supplement the terms of this License with terms:

    a) Disclaiming warranty or limiting liability differently from the
    terms of sections 15 and 16 of this License; or

    b) Requiring preservation of specified reasonable legal notices or
    author attributions in that material or in the Appropriate Legal
    Notices displayed by works containing it; or

    c) Prohibiting misrepresentation of the origin of that material, or
    requiring that modified versions of such material be marked in
    reasonable ways as different from the original version; or

    d) Limiting the use for publicity purposes of names of licensors or
    authors of the material; or

    e) Declining to grant rights under trademark law for use of some
    trade names, trademarks, or service marks; or

    f) Requiring indemnification of licensors and authors of that
    material by anyone who conveys the material (or modified versions of
    it) with contractual assumptions of liability to the recipient, for
    any liability that these contractual assumptions directly impose on
    those licensors and authors.

  All other non-permissive additional terms are considered 'further
restrictions' within the meaning of section 10.  If the Program as you
received it, or any part of it, contains a notice stating that it is
governed by this License along with a term that is a further
restriction, you may remove that term.  If a license document contains
a further restriction but permits relicensing or conveying under this
License, you may add to a covered work material governed by the terms
of that license document, provided that the further restriction does
not survive such relicensing or conveying.

  If you add terms to a covered work in accord with this section, you
must place, in the relevant source files, a statement of the
additional terms that apply to those files, or a notice indicating
where to find the applicable terms.

  Additional terms, permissive or non-permissive, may be stated in the
form of a separately written license, or stated as exceptions;
the above requirements apply either way.

  8. Termination.

  You may not propagate or modify a covered work except as expressly
provided under this License.  Any attempt otherwise to propagate or
modify it is void, and will automatically terminate your rights under
this License (including any patent licenses granted under the third
paragraph of section 11).

  However, if you cease all violation of this License, then your
license from a particular copyright holder is reinstated (a)
provisionally, unless and until the copyright holder explicitly and
finally terminates your license, and (b) permanently, if the copyright
holder fails to notify you of the violation by some reasonable means
prior to 60 days after the cessation.

  Moreover, your license from a particular copyright holder is
reinstated permanently if the copyright holder notifies you of the
violation by some reasonable means, this is the first time you have
received notice of violation of this License (for any work) from that
copyright holder, and you cure the violation prior to 30 days after
your receipt of the notice.

  Termination of your rights under this section does not terminate the
licenses of parties who have received copies or rights from you under
this License.  If your rights have been terminated and not permanently
reinstated, you do not qualify to receive new licenses for the same
material under section 10.

  9. Acceptance Not Required for Having Copies.

  You are not required to accept this License in order to receive or
run a copy of the Program.  Ancillary propagation of a covered work
occurring solely as a consequence of using peer-to-peer transmission
to receive a copy likewise does not require acceptance.  However,
nothing other than this License grants you permission to propagate or
modify any covered work.  These actions infringe copyright if you do
not accept this License.  Therefore, by modifying or propagating a
covered work, you indicate your acceptance of this License to do so.

  10. Automatic Licensing of Downstream Recipients.

  Each time you convey a covered work, the recipient automatically
receives a license from the original licensors, to run, modify and
propagate that work, subject to this License.  You are not responsible
for enforcing compliance by third parties with this License.

  An 'entity transaction' is a transaction transferring control of an
organization, or substantially all assets of one, or subdividing an
organization, or merging organizations.  If propagation of a covered
work results from an entity transaction, each party to that
transaction who receives a copy of the work also receives whatever
licenses to the work the party's predecessor in interest had or could
give under the previous paragraph, plus a right to possession of the
Corresponding Source of the work from the predecessor in interest, if
the predecessor has it or can get it with reasonable efforts.

  You may not impose any further restrictions on the exercise of the
rights granted or affirmed under this License.  For example, you may
not impose a license fee, royalty, or other charge for exercise of
rights granted under this License, and you may not initiate litigation
(including a cross-claim or counterclaim in a lawsuit) alleging that
any patent claim is infringed by making, using, selling, offering for
sale, or importing the Program or any portion of it.

  11. Patents.

  A 'contributor' is a copyright holder who authorizes use under this
License of the Program or a work on which the Program is based.  The
work thus licensed is called the contributor's 'contributor version'.

  A contributor's 'essential patent claims' are all patent claims
owned or controlled by the contributor, whether already acquired or
hereafter acquired, that would be infringed by some manner, permitted
by this License, of making, using, or selling its contributor version,
but do not include claims that would be infringed only as a
consequence of further modification of the contributor version.  For
purposes of this definition, 'control' includes the right to grant
patent sublicenses in a manner consistent with the requirements of
this License.

  Each contributor grants you a non-exclusive, worldwide, royalty-free
patent license under the contributor's essential patent claims, to
make, use, sell, offer for sale, import and otherwise run, modify and
propagate the contents of its contributor version.

  In the following three paragraphs, a 'patent license' is any express
agreement or commitment, however denominated, not to enforce a patent
(such as an express permission to practice a patent or covenant not to
sue for patent infringement).  To 'grant' such a patent license to a
party means to make such an agreement or commitment not to enforce a
patent against the party.

  If you convey a covered work, knowingly relying on a patent license,
and the Corresponding Source of the work is not available for anyone
to copy, free of charge and under the terms of this License, through a
publicly available network server or other readily accessible means,
then you must either (1) cause the Corresponding Source to be so
available, or (2) arrange to deprive yourself of the benefit of the
patent license for this particular work, or (3) arrange, in a manner
consistent with the requirements of this License, to extend the patent
license to downstream recipients.  'Knowingly relying' means you have
actual knowledge that, but for the patent license, your conveying the
covered work in a country, or your recipient's use of the covered work
in a country, would infringe one or more identifiable patents in that
country that you have reason to believe are valid.

  If, pursuant to or in connection with a single transaction or
arrangement, you convey, or propagate by procuring conveyance of, a
covered work, and grant a patent license to some of the parties
receiving the covered work authorizing them to use, propagate, modify
or convey a specific copy of the covered work, then the patent license
you grant is automatically extended to all recipients of the covered
work and works based on it.

  A patent license is 'discriminatory' if it does not include within
the scope of its coverage, prohibits the exercise of, or is
conditioned on the non-exercise of one or more of the rights that are
specifically granted under this License.  You may not convey a covered
work if you are a party to an arrangement with a third party that is
in the business of distributing software, under which you make payment
to the third party based on the extent of your activity of conveying
the work, and under which the third party grants, to any of the
parties who would receive the covered work from you, a discriminatory
patent license (a) in connection with copies of the covered work
conveyed by you (or copies made from those copies), or (b) primarily
for and in connection with specific products or compilations that
contain the covered work, unless you entered into that arrangement,
or that patent license was granted, prior to 28 March 2007.

  Nothing in this License shall be construed as excluding or limiting
any implied license or other defenses to infringement that may
otherwise be available to you under applicable patent law.

  12. No Surrender of Others' Freedom.

  If conditions are imposed on you (whether by court order, agreement or
otherwise) that contradict the conditions of this License, they do not
excuse you from the conditions of this License.  If you cannot convey a
covered work so as to satisfy simultaneously your obligations under this
License and any other pertinent obligations, then as a consequence you may
not convey it at all.  For example, if you agree to terms that obligate you
to collect a royalty for further conveying from those to whom you convey
the Program, the only way you could satisfy both those terms and this
License would be to refrain entirely from conveying the Program.

  13. Use with the GNU Affero General Public License.

  Notwithstanding any other provision of this License, you have
permission to link or combine any covered work with a work licensed
under version 3 of the GNU Affero General Public License into a single
combined work, and to convey the resulting work.  The terms of this
License will continue to apply to the part which is the covered work,
but the special requirements of the GNU Affero General Public License,
section 13, concerning interaction through a network will apply to the
combination as such.

  14. Revised Versions of this License.

  The Free Software Foundation may publish revised and/or new versions of
the GNU General Public License from time to time.  Such new versions will
be similar in spirit to the present version, but may differ in detail to
address new problems or concerns.

  Each version is given a distinguishing version number.  If the
Program specifies that a certain numbered version of the GNU General
Public License 'or any later version' applies to it, you have the
option of following the terms and conditions either of that numbered
version or of any later version published by the Free Software
Foundation.  If the Program does not specify a version number of the
GNU General Public License, you may choose any version ever published
by the Free Software Foundation.

  If the Program specifies that a proxy can decide which future
versions of the GNU General Public License can be used, that proxy's
public statement of acceptance of a version permanently authorizes you
to choose that version for the Program.

  Later license versions may give you additional or different
permissions.  However, no additional obligations are imposed on any
author or copyright holder as a result of your choosing to follow a
later version.

  15. Disclaimer of Warranty.

  THERE IS NO WARRANTY FOR THE PROGRAM, TO THE EXTENT PERMITTED BY
APPLICABLE LAW.  EXCEPT WHEN OTHERWISE STATED IN WRITING THE COPYRIGHT
HOLDERS AND/OR OTHER PARTIES PROVIDE THE PROGRAM 'AS IS' WITHOUT WARRANTY
OF ANY KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING, BUT NOT LIMITED TO,
THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
PURPOSE.  THE ENTIRE RISK AS TO THE QUALITY AND PERFORMANCE OF THE PROGRAM
IS WITH YOU.  SHOULD THE PROGRAM PROVE DEFECTIVE, YOU ASSUME THE COST OF
ALL NECESSARY SERVICING, REPAIR OR CORRECTION.

  16. Limitation of Liability.

  IN NO EVENT UNLESS REQUIRED BY APPLICABLE LAW OR AGREED TO IN WRITING
WILL ANY COPYRIGHT HOLDER, OR ANY OTHER PARTY WHO MODIFIES AND/OR CONVEYS
THE PROGRAM AS PERMITTED ABOVE, BE LIABLE TO YOU FOR DAMAGES, INCLUDING ANY
GENERAL, SPECIAL, INCIDENTAL OR CONSEQUENTIAL DAMAGES ARISING OUT OF THE
USE OR INABILITY TO USE THE PROGRAM (INCLUDING BUT NOT LIMITED TO LOSS OF
DATA OR DATA BEING RENDERED INACCURATE OR LOSSES SUSTAINED BY YOU OR THIRD
PARTIES OR A FAILURE OF THE PROGRAM TO OPERATE WITH ANY OTHER PROGRAMS),
EVEN IF SUCH HOLDER OR OTHER PARTY HAS BEEN ADVISED OF THE POSSIBILITY OF
SUCH DAMAGES.

  17. Interpretation of Sections 15 and 16.

  If the disclaimer of warranty and limitation of liability provided
above cannot be given local legal effect according to their terms,
reviewing courts shall apply local law that most closely approximates
an absolute waiver of all civil liability in connection with the
Program, unless a warranty or assumption of liability accompanies a
copy of the Program in return for a fee.

                     END OF TERMS AND CONDITIONS

            How to Apply These Terms to Your New Programs

  If you develop a new program, and you want it to be of the greatest
possible use to the public, the best way to achieve this is to make it
free software which everyone can redistribute and change under these terms.

  To do so, attach the following notices to the program.  It is safest
to attach them to the start of each source file to most effectively
state the exclusion of warranty; and each file should have at least
the 'copyright' line and a pointer to where the full notice is found.

    <one line to give the program's name and a brief idea of what it does.>
    Copyright (C) <year>  <name of author>

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

Also add information on how to contact you by electronic and paper mail.

  If the program does terminal interaction, make it output a short
notice like this when it starts in an interactive mode:

    <program>  Copyright (C) <year>  <name of author>
    This program comes with ABSOLUTELY NO WARRANTY; for details type `show w'.
    This is free software, and you are welcome to redistribute it
    under certain conditions; type `show c' for details.

The hypothetical commands `show w' and `show c' should show the appropriate
parts of the General Public License.  Of course, your program's commands
might be different; for a GUI interface, you would use an 'about box'.

  You should also get your employer (if you work as a programmer) or school,
if any, to sign a 'copyright disclaimer' for the program, if necessary.
For more information on this, and how to apply and follow the GNU GPL, see
<http://www.gnu.org/licenses/>.

  The GNU General Public License does not permit incorporating your program
into proprietary programs.  If your program is a subroutine library, you
may consider it more useful to permit linking proprietary applications with
the library.  If this is what you want to do, use the GNU Lesser General
Public License instead of this License.  But first, please read
<http://www.gnu.org/philosophy/why-not-lgpl.html>.";
			echo "</pre></div><br />";
			
			//Next Button
			echo "By clicking 'Next' you agree to the terms stated in the licence above.<br />
			<form method='POST' action='./index.php'>
			<input type='hidden' name='action' value='{$nextpage}' />
			<input type='submit' value='Next' />
			</form>";
		}				
		
		function database()		
		{			
			$nextpage = "do_database";						
			
			//DB Intro and Fields	
			echo "<form method='POST' action='./index.php'>";
			echo "Enter your DB Hostname, User, Password and Database below to continue MillionCMS's installation.<br /><br />";			
			echo "<table border='0'><tr><td><img src='./images/database.png'></td><td>
			Hostname: <br /><input type='text' name='hostname' /><br />";
			$db_list = " 
			<select name='db_type'>
				<option value='mysqli'>MySQLi</option>
				<option value='mysql'>MySQL</option>
				<option value='pgsql'>PostgreSQL</option>
			</select>";
			echo "Database Type: <br />{$db_list}<br />";
			echo "Username: <br /><input type='text' name='username' /><br />";
			echo "Password: <br /><input type='password' name='password' /><br />";
			echo "Database: <br /><input type='text' name='database' /><br />";
			echo "Table Prefix: <br /><input type='text' name='table_prefix' value='mcms_' />
			</td></tr></table><br /><br />";
			
			//Next Button
			echo "Click 'Next' to continue.<br />
			<input type='hidden' name='action' value='{$nextpage}' />
			<input type='submit' value='Next' />
			</form>";
		}
		
		function do_database()
		{
			$nextpage="do_database_admin";
			
			//Init Variables
			// $dbtype = $_POST['db_type'];
			$hostname = $_POST['hostname'];
			$username = $_POST['username'];
			$password = $_POST['password'];
			$database = $_POST['database'];
			$prefix = $_POST['table_prefix'];
			
			if (empty($hostname)) //If hostname empty set message and redirect
			{
				error("You must provide a hostname!");
				database();
			}
			
			elseif (empty($username)) //If username empty set message and redirect
			{
				error("You must provide a username!");
				database();
			}
			
			elseif (empty($database)) //If database empty set message and redirect
			{
				error("You must provide a database name!");
				database();
			}
			
			else
			{
				$connect = mysql_connect("{$hostname}","{$username}","{$password}");
				$select = mysql_select_db("{$database}");
				
				if (!$connect && !$select)
				{	
					error("Cannot connect to host or database");
					database();
				}
				
				elseif (!$connect)
				{
					error("Cannot connect to host");
					database();
				}
				
				elseif (!$select)
				{
					error("Cannot connect to database");
					database();
				}
				
				else
				{
					//Echo stuff and run queries to create basic tables
					echo "Connected Successfully.<br />Running Queries...<br /><br />";
					include ("./resources/tables.php");
					
					echo "Adding Pages Table...";
					$delete1 = mysql_query("DROP table if exists {$prefix}pages") or error("Failed to execute query - " . mysql_error());
					$result1 = mysql_query($create1) or error("Failed to add pages table into DB - " . mysql_error());
					
					echo "Adding Users Table...";
					$delete2 = mysql_query("DROP table if exists {$prefix}users") or error("Failed to execute query - " . mysql_error());
					$result2 = mysql_query($create2) or error("Failed to add users table into DB - " . mysql_error());
					
					echo "Adding Reports Table...";
					$delete3 = mysql_query("DROP table if exists {$prefix}reports") or error("Failed to execute query - " . mysql_error());
					$result3 = mysql_query($create3) or error("Failed to add reports table into DB - " . mysql_error());
					
					echo "Adding Settings Table...";
					$delete4 = mysql_query("DROP table if exists {$prefix}settings") or error("Failed to execute query - " . mysql_error());
					$result4 = mysql_query($create4) or error("Failed to add settings table into DB - " . mysql_error());
					
					echo "Adding Templates Table...";
					$delete5 = mysql_query("DROP table if exists {$prefix}templates") or error("Failed to execute query - " . mysql_error());
					$result5 = mysql_query($create5) or error("Failed to add templates table into DB - " . mysql_error());
					
					echo "<small>Inserted page_create template...</small>";
					$result6 = mysql_query($insert1) or error("Failed to insert page_create template into DB - " . mysql_error());
					
					echo "<small>Inserted page_view template...</small>";
					$result7 = mysql_query($insert2) or error("Failed to insert page_view template into DB - " . mysql_error());
					
					echo "<small>Inserted header template...</small>";
					$result8 = mysql_query($insert3) or error("Failed to insert header template into DB - " . mysql_error());
					
					echo "<small>Inserted index template...</small>";
					$result9 = mysql_query($insert4) or error("Failed to insert index template into DB - " . mysql_error());
					
					echo "<small>Inserted options_page template...</small>";
					$result10 = mysql_query($insert5) or error("Failed to insert options_page template into DB - " . mysql_error());
					
					echo "<small>Inserted footer template...</small>";
					$result11 = mysql_query($insert6) or error("Failed to insert footer template into DB - " . mysql_error());
					
					echo "<small>Inserted header_includes template...</small>";
					$result12 = mysql_query($insert7) or error("Failed to insert header_includes template into DB - " . mysql_error());
					
					echo "<small>Inserted page_toolbox template...</small>";
					$result13 = mysql_query($insert8) or error("Failed to insert page_toolbox template into DB - " . mysql_error());
					
					echo "<small>Inserted toolbox_content_home template...</small>";
					$result14 = mysql_query($insert9) or error("Failed to insert toolbox_content_home template into DB - " . mysql_error());
					
					echo "<small>Inserted sidebar_toolbox template...</small>";
					$result15 = mysql_query($insert10) or error("Failed to insert sidebar_toolbox template into DB - " . mysql_error());
					
					echo "<small>Inserted toolbox_create template...</small>";
					$result16 = mysql_query($insert11) or error("Failed to insert toolbox_create template into DB - " . mysql_error());
					
					echo "<small>Inserted toolbox_plist template...</small>";
					$result17 = mysql_query($insert12) or error("Failed to insert toolbox_plist template into DB - " . mysql_error());
					
					echo "<small>Inserted header_guest template...</small>";
					$result18 = mysql_query($insert13) or error("Failed to insert header_guest template into DB - " . mysql_error());
					
					echo "<small>Inserted header_admin template...</small>";
					$result19 = mysql_query($insert14) or error("Failed to insert header_admin template into DB - " . mysql_error());
					
					echo "<small>Inserted report_view template...</small>";
					$result20 = mysql_query($insert15) or error("Failed to insert report_view template into DB - " . mysql_error());
					
					echo "<small>Inserted page_view_report template...</small>";
					$result21 = mysql_query($insert16) or error("Failed to insert page_view_report template into DB - " . mysql_error());
					
					echo "<small>Inserted report_view_toolbox template...</small>";
					$result22 = mysql_query($insert17) or error("Failed to insert report_view_toolnox template into DB - " . mysql_error());
					
					echo "<small>Inserted toolbox_report_page template...</small>";
					$result23 = mysql_query($insert18) or error("Failed to insert toolbox_report_page template into DB - " . mysql_error());
					
					echo "<small>Inserted toolbox_report_list template...</small>";
					$result24 = mysql_query($insert19) or error("Failed to insert toolbox_report_list template into DB - " . mysql_error());
					
					echo "<small>Inserted toolbox_report_view template...</small>";
					$result25 = mysql_query($insert20) or error("Failed to insert toolbox_report_view template into DB - " . mysql_error());
					
					echo "<small>Inserted header_member template...</small>";
					$result26 = mysql_query($insert21) or error("Failed to insert header_member template into DB - " . mysql_error());
					
					echo "<small>Inserted toolbox_options_avatar template...</small>";
					$result27 = mysql_query($insert22) or error("Failed to insert toolbox_options_avatar template into DB - " . mysql_error());
					
					echo "Adding Usergroups Table...";
					$result28 = mysql_query($create6) or error("Failed to add usergroups table into DB - " . mysql_error());
					
					echo "<small>Inserted Guests usergroup...</small>";
					$result29 = mysql_query($ugroup1) or error("Failed to insert Guests usergroup into DB - " . mysql_error());
					
					echo "<small>Generated Guests usergroup permissions...</small>";
					$result30 = mysql_query($perms1) or error("Failed to insert Guests usergroup permissions into DB - " . mysql_error());
					
					echo "<small>Inserted Registered usergroup...</small>";
					$result31 = mysql_query($ugroup2) or error("Failed to insert Registered usergroup into DB - " . mysql_error());
					
					echo "<small>Generated Registered usergroup permissions...</small>";
					$result32 = mysql_query($perms2) or error("Failed to insert Registered usergroup permissions into DB - " . mysql_error());
					
					echo "<small>Inserted Contributor usergroup...</small>";
					$result33 = mysql_query($ugroup3) or error("Failed to insert Contributer usergroup into DB - " . mysql_error());
					
					echo "<small>Generated Contributor usergroup permissions...</small>";
					$result34 = mysql_query($perms3) or error("Failed to insert Contributor usergroup permissions into DB - " . mysql_error());
					
					echo "<small>Inserted Editor usergroup...</small>";
					$result35 = mysql_query($ugroup4) or error("Failed to insert Editor usergroup into DB - " . mysql_error());
					
					echo "<small>Generated Editor usergroup permissions...</small>";
					$result36 = mysql_query($perms4) or error("Failed to insert Editor usergroup permissions into DB - " . mysql_error());
					
					echo "<small>Inserted Administrator usergroup...</small>";
					$result37 = mysql_query($ugroup5) or error("Failed to insert Administrator usergroup into DB - " . mysql_error());

					echo "<small>Generated Administrator usergroup permissions...</small>";
					$result38 = mysql_query($perms5) or error("Failed to insert Administrator usergroup permissions into DB - " . mysql_error());

					echo "<small>Inserted default index page...</small>";
					$result39 = mysql_query($page1) or error("Failed to insert default index page into DB - " . mysql_error());
					
					echo "<small>Inserted toolbox_edit template...</small>";
					$result40 = mysql_query($insert23) or error("Failed to insert toolbox_edit template into DB - " . mysql_error());

					echo "<small>Inserted usercp_page template...</small>";
					$result41 = mysql_query($insert24) or error("Failed to insert usercp_page template into DB - " . mysql_error());

					echo "<small>Inserted sidebar_toolbox_reportbit template...</small>";
					$result42 = mysql_query($insert25) or error("Failed to insert sidebar_toolbox_reportbit template into DB - " . mysql_error());

					echo "Adding Comments Table...";
					$delete6 = mysql_query("DROP table if exists {$prefix}comments") or error("Failed to execute query - " . mysql_error());
					$result43 = mysql_query($create7) or error("Failed to add comments table into DB - " . mysql_error());

					echo "Adding Cache Table...";
					$delete7 = mysql_query("DROP table if exists {$prefix}cache") or error("Failed to execute query - " . mysql_error());
					$result44 = mysql_query($create8) or error("Failed to add cache table into DB - " . mysql_error());

					echo "<small>Inserted login_login template...</small>";
					$result45 = mysql_query($insert26) or error("Failed to insert login_login template into DB - " . mysql_error());

					echo "<small>Inserted gadgets cache...</small>";
					$result46 = mysql_query($cache1) or error("Failed to insert gadgets cache into DB - " . mysql_error());
					
					echo "<small>Inserted admin_notes cache...</small>";
					$result47 = mysql_query($cache2) or error("Failed to insert admin_notes cache into DB - " . mysql_error());
					
					echo "<small>Inserted page_contact template...</small>";
					$result48 = mysql_query($insert27) or error("Failed to insert page_contact template into DB - " . mysql_error());
					
					echo "<small>Inserted view_uid template...</small>";
					$result49 = mysql_query($insert28) or error("Failed to insert view_uid template into DB - " . mysql_error());

					echo "<small>Inserted regperms cache...</small>";
					$result50 = mysql_query($cache3) or error("Failed to insert regperms cache into DB - " . mysql_error());

					echo "<small>Inserted adminperms cache...</small>";
					$result51 = mysql_query($cache4) or error("Failed to insert adminperms cache into DB - " . mysql_error());

					echo "<small>Inserted lastadminlogins cache...</small>";
					$result52 = mysql_query($cache5) or error("Failed to insert lastadminlogins cache into DB - " . mysql_error());
					
					echo "<small>Inserted cacheexpiry cache...</small>";
					$result53 = mysql_query($cache6) or error("Failed to insert cacheexpiry cache into DB - " . mysql_error());

					echo "<small>Inserted login_lostpw template...</small>";
					$result54 = mysql_query($insert29) or error("Failed to insert login_lostpw template into DB - " . mysql_error());

					echo "Creating Config File...<br /><br />";
					
					//Create Config
					$config = "<?php
/*
MillionCMS Project
    
Name: Configuration File (config.php)
Version: 
Description: config.php manages the connection to the database and 
other important details.

Author: Kyuubi, added to installer by Azareal


Copyright © 2010 MillionCMS Group


This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

// Database Name
// This is the name of your database. On shared hosts, this will be
// prefixed by your account name.
\$config['db']['name'] = '{$database}';

// Database Username
// This is the username that is used to connect to your database. This
// will also be prefixed by your account name.
\$config['db']['uname'] = '{$username}';

// Database Password
// The password used to access the database. This is NOT prefixed with
// your account name.
\$config['db']['pass'] = '{$password}';

// Database Host
// Where the MySQL database system is located. On many hosts, this will
// be the default below, so you will not need to change the settings.
// ONLY CHANGE THIS IF YOUR HOST REQUIRES YOU TO DO SO.
\$config['db']['host'] = '{$hostname}';
\$config['host_port'] = '3306';

// Database Type
// The type of database that you use.
\$config['db']['type'] = 'mysql';

// Table Prefix
// A name you can give your tables in the database. You don't need to
// provide a table prefix, but some people do this if they are 
// restricted in the number of database's they can create. The default
// prefix is ifcms_.
\$config['table_prefix'] = '{$prefix}';

// Super Administrator
// The id's of user's below will have permanent admin access, and can't
// be removed of admin permissions. For security reasons, you should
// leave this at id 1.
\$config['super_admins'] = '1';

// Unalterable
// Users in this variable are immortal to all other administrators.
// You can use this on as many users as you want, but we recommend that
// you use this on administrators only.
\$config['unalterable'] = '1';

// Datacache Systems
// If you have a Datacache system installed on your server (eg Memcache)
// then you can use these to speed up your site.
\$config['php_accelerator'] = '';
\$config['database_accelerator'] = '';

// Admin Control Panel Directory
// If you wish to change the name of the directory 
// in which the acp is situated for security reasons change this variable.
// Note you will also have to manually rename the folder called admin to match
// what is provided here.
// The default setting is admin.
\$config['admin_dir'] = 'admin';
?>";
					$file = fopen('../inc/config.php', 'w');
					fwrite($file, $config);
					fclose($file);
					echo "Done.<br />";
					
					
					//Next Button
					echo "Click 'Next' to continue.<br />
					<form method='POST' action='./index.php'>
					<input type='hidden' name='action' value='{$nextpage}' />
					<input type='submit' value='Next' /></form>";
					redirect("index.php?action={$nextpage}",3);
				}
			}
		}

		function do_database_admin()
		{
			$nextpage="settings";
			sql_connect();
			// Echo stuff and run queries to create admin tables.
			echo "The installer will now create the AdminCP Templates...<br /><br />";
			require("../inc/config.php");
			$prefix = $config['table_prefix'];
			$badquery = false;
			include ("./resources/tables_admin.php");
			// Admin Templates Table
			echo "Adding Admin Templates Table...";
			$delete1 = mysql_query("DROP table if exists ".TABLE_PREFIX."admin_templates") or error("Failed to execute query - " . mysql_error()).$badquery = true;
			$result1 = mysql_query($create1) or error("Failed to add admin_templates table into DB - " . mysql_error()).$badquery = true;
			// Admin Styles Table
			echo "Adding Admin Styles Table...";
			$delete2 = mysql_query("DROP table if exists {$prefix}admin_styles") or error("Failed to execute query - " . mysql_error()).$badquery = true;
			$result2 = mysql_query($create2) or error("Failed to add admin_styles table into DB - " . mysql_error()).$badquery = true;
			// Admin Logs Table (yes, we have one now)
			echo "Adding Admin Logs Table...";
			$delete3 = mysql_query("DROP table if exists {$prefix}admin_logs") or error("Failed to execute query - " . mysql_error()).$badquery = true;
			$result3 = mysql_query($create3) or error("Failed to add admin_logs table into DB - " . mysql_error()).$badquery = true;
			
			// Default admin index template
			echo "<small>Adding admin_index admin template..</small>";
			$result1 = mysql_query($insert1) or error("Failed to add admin_index into DB - " . mysql_error()).$badquery = true;
			
			// Normal View Queries
			$nresult1 = mysql_query($normal_view) or error("Failed to add normal view style into DB - " . mysql_error()).$badquery = true;
			$nresult2 = mysql_query($ntemplate1) or error("Failed to add admin_start normal view template into DB - " . mysql_error()).$badquery = true;

			// Advance View Queries
			$aresult1 = mysql_query($advance_view) or error("Failed to add advance view style into DB - " . mysql_error()).$badquery = true;
			$aresult2 = mysql_query($atemplate1) or error("Failed to add admin_redirect advance view template into DB - " . mysql_error()).$badquery = true;
			$aresult3 = mysql_query($atemplate2) or error("Failed to add admin_start advance view template into DB - " . mysql_error()).$badquery = true;
			$aresult4 = mysql_query($atemplate3) or error("Failed to add header_includes advance view template into DB - " . mysql_error()).$badquery = true;
			$aresult5 = mysql_query($atemplate4) or error("Failed to add header advance view template into DB - " . mysql_error()).$badquery = true;
			$aresult6 = mysql_query($atemplate5) or error("Failed to add sidebar advance view template into DB - " . mysql_error()).$badquery = true;

			echo "Done.<br />";

			// Only show this if nothing has gone wrong.
			if(!$badquery)
			{
				echo "Click 'Next' to continue.<br />
				<form method='POST' action='./index.php'>
				<input type='hidden' name='action' value='{$nextpage}' />
				<input type='submit' value='Next' /></form>";
				redirect("index.php?action={$nextpage}",2);
			}
		}

		function settings()
		{
			$nextpage = "do_settings";
			if ($_SERVER['HTTPS'] != NULL)
			{
				$s = "s";
			}
			
			$url = 'http'. $s .'://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			$url = dirname(dirname($url));

			if($_GET['error'] == 'email')
			{
				$email_error = error("You have entered an invalid email address. Please check that the entered email is valid.");
				echo $email_error;
			}
			// DB Intro and Fields	
			echo "<form method='POST' action='./index.php'>";
			echo "Enter your desired settings below to continue MillionCMS's installation.<br /><br />";			
			echo "<table border='0'><tr><td><img src='./images/configure.png'></td><td>
			Site URL: <br /><input type='text' name='siteurl' value='{$url}' /><br />";	
			echo "Home URL: <br /><input type='text' name='homeurl' value='".'http'.$s.'://'.$_SERVER['HTTP_HOST']."' /><br />
			<small>Do not include the trailing slash '/'</small>";
			echo "Webmaster Email: <br /><input type='text' name='wemail' value='webmaster@{$_SERVER['HTTP_HOST']}' /><br />
			Site Name: <br /><input type='text' name='sitename' value='Default Install' /></td>
			</tr></table><br /><br />";
			echo "Click 'Next' to continue.<br />
			<input type='hidden' name='action' value='{$nextpage}' />
			<input type='submit' value='Next' /></form>";
		}
		
		function do_settings()
		{
			$nextpage = "admin";
			sql_connect();
			$siteurl = mysql_real_escape_string($_POST['siteurl']);
			$homeurl = mysql_real_escape_string($_POST['homeurl']);
			$wemail = mysql_real_escape_string($_POST['wemail']);
			$sitename = mysql_real_escape_string($_POST['sitename']);
			$terror = 0;

			if (empty($siteurl) || empty($homeurl) || empty($wemail) || empty($sitename))
			{
				error("Please fill in all the fields!");
			}
			elseif(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$",$wemail))
			{ 
				$email_error = error("You have entered an invalid email address. Please check that the entered email is valid.");
				$terror = 1;
				redirect("index.php?action=settings&error=email",0);
			}
			else
			{
				$addsettings = mysql_query("INSERT into ".TABLE_PREFIX."settings(name, content) VALUES ('siteurl','{$siteurl}')");
				$addsettings2 = mysql_query("INSERT into ".TABLE_PREFIX."settings(name, content) VALUES ('homeurl','{$homeurl}')");
				$addsettings3 = mysql_query("INSERT into ".TABLE_PREFIX."settings(name, content) VALUES ('site_email','{$wemail}')");
				$addsettings4 = mysql_query("INSERT into ".TABLE_PREFIX."settings(name, content) VALUES ('site_name','{$sitename}')");
				$addsettings5 = mysql_query("INSERT into ".TABLE_PREFIX."settings(name, content) VALUES ('avatar_maxheight','125')");
				$addsettings6 = mysql_query("INSERT into ".TABLE_PREFIX."settings(name, content) VALUES ('avatar_maxwidth','125')");
				$addsettings7 = mysql_query("INSERT into ".TABLE_PREFIX."settings(name, content) VALUES ('site_message','0')");
				$addsettings8 = mysql_query("INSERT into ".TABLE_PREFIX."settings(name, content) VALUES ('site_switch','1')");

				if (!$addsettings)
				{
					error("Failed to insert siteurl setting into DB - " . mysql_error());
					$terror = 1;
				}
				
				if (!$addsettings2)
				{
					error("Failed to insert homeurl setting into DB - " . mysql_error());
					$terror = 1;
				}
				
				if (!$addsettings3)
				{
					error("Failed to insert site_email setting into DB - " . mysql_error());
					$terror = 1;
				}
				
				if (!$addsettings4)
				{
					error("Failed to insert site_name setting into DB - " . mysql_error());
					$terror = 1;
				}
				
				if (!$addsettings5)
				{
					error("Failed to insert avatar_maxheight setting into DB - " . mysql_error());
					$terror = 1;
				}
				
				if (!$addsettings6)
				{
					error("Failed to insert avatar_maxwidth setting into DB - " . mysql_error());
					$terror = 1;
				}
				
				if (!$addsettings7)
				{
					error("Failed to insert site_message setting into DB - " . mysql_error());
					$terror = 1;
				}
				
				if (!$addsettings8)
				{
					error("Failed to insert site_switch setting into DB - " . mysql_error());
					$terror = 1;
				}
				
				if($terror!=1)
				{
					echo "Inserting Settings into DB...<br /><br />";
					echo "Done.<br />";
					
					// Next Button
					echo "Click 'Next' to continue.<br />
					<form method='POST' action='./index.php'>
					<input type='hidden' name='action' value='{$nextpage}' />
					<input type='submit' value='Next' /></form>";
					redirect("index.php?action={$nextpage}",3);
				}
			}
		}
		
		function admin()
		{
			$nextpage = "do_admin";
			if($_GET['error'] == 'email')
			{
				$email_error = error("You have entered an invalid email address. Please check that the entered email is valid.");
				echo $email_error;
			}
			//DB Intro and Fields	
			echo "<form method='POST' action='./index.php'>";
			echo "Enter your wanted Admin Details below to continue MillionCMS's installation.<br /><br />";			
			echo "<table border='0'><tr><td><img src='./images/admin.png'></td><td>Username: <br />
			<input type='text' name='username' /><br />";	
			echo "Password: <br /><input type='password' name='password' /><br />";
			echo "Email: <br /><input type='text' name='email' /></td></tr></table><br /><br />";
			
			//Next Button
			echo "Click 'Next' to continue.<br />
			<input type='hidden' name='action' value='{$nextpage}' />
			<input type='submit' value='Next' /></form>";
		}
		
		function do_admin()
		{
			$nextpage = "finish";
			sql_connect();
			$username = mysql_real_escape_string($_POST['username']);
			$password = mysql_real_escape_string($_POST['password']);
			$email = mysql_real_escape_string($_POST['email']);

			if (empty($username) || empty($password) || empty($email))
			{
				error("Please fill in all the fields!");
			}
			
			elseif(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$",$email))
			{ 
				$email_error = error("You have entered an invalid email address. Please check that the entered email is valid.");
				$terror = 1;
				redirect("index.php?action=admin&error=email",0);
			}		
			
			else
			{
				// Encrypt password with existing salt
				$salt = random_str(10);
				$epassword = md5($salt.md5($password.$salt));
				$epassword = md5($epassword);
				
				$addadmin = mysql_query("INSERT into ".TABLE_PREFIX."users(username, password, salt, email, gid) VALUES ('{$username}','{$epassword}','{$salt}','{$email}','5')");
			
				if (!$addadmin)
				{
					error("Failed to add admin account into DB - " . mysql_error());
				}
			
				else
				{
					echo "Inserting Admin Account into DB...<br /><br />";
					echo "Done.<br />";
					
					//Next Button
					echo "Click 'Finish' to complete MillionCMS's installation.<br />
					<form method='POST' action='./index.php'>
					<input type='hidden' name='action' value='{$nextpage}' />
					<input type='submit' value='Finish' /></form>";
					redirect("index.php?action={$nextpage}",3);
				}
			}
		}
		
		function finish()
		{
			$lock = @fopen('./lock', 'w');
			$written = @fwrite($lock, 'locked');
			@fclose($lock);
		
			echo "<h2>Congratulations! MillionCMS has been installed successfully!</h2>";
			echo "<table border='0'><tr><td><img src='./images/success.png'></td><td>Your installer has also been locked to prevent unauthorised reinstalls or updates.<br />";
			echo "To start using MillionCMS click <a href='../index.php'>here</a> and you will be taken directly to the homepage where you can login to your admin account.<br /><br />";
			echo "Please remember if you have any problems with our software please make a support request over at our <a href='http://forums.millioncms.com'>Support Forums</a>.<br />";
			echo "If you happen to encounter any bugs with MillionCMS (which may be likely as this is a Preview release) please report them onto our <a href='http://tracker.millioncms.com/projects/millioncms/issues'>MillionCMS Development Site
			</a>.</td></tr></table>";
		}
		
		function locked()
		{
			echo "<table border='0'><tr><td><img src='./images/lock.png'></td><td>";
			error("The Installer is Locked and therefore cannot continue. Please remove the 'lock' file to continue and refresh.");
			echo "If this problem continues please feel free to make a support request over at our 
			<a href='http://forums.millioncms.com'>Support Forums</a>.</td></tr></table>";
		}
		?>		
		</div>		
		 <div id="footer">
			&copy; <?php 
			$copyYear = 2010; 
			$curYear = date('Y'); 
			echo $copyYear . (($copyYear != $curYear) ? '-' . $curYear : ''); ?>
			Powered by <a href="http://millioncms.com/">MillionCMS</a> Alpha 3 Dev
	     </div>		 
</div>
</body>
</html>