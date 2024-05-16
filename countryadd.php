<?php require_once('header.php'); 

$query_user = "select * from users_login where role = '2'";
$result_user = mysqli_query($connection , $query_user);


		/*
if(isset($_POST['submit']))
{
	
	$select_cust_credit = "select credit from cc_card where id='".$_POST['clientId']."'";
	$result_cust = mysqli_query($connection, $select_cust_credit);
	// if(mysqli_fetch_array($result_cust)>0)
	// {
		while($rowcredit = mysqli_fetch_array($result_cust))
		{
			$current_credit = $rowcredit['credit'];
		}
		$updated_credit = ($current_credit + $_POST['credit']);
		
		$update_credit = "update cc_card set credit='".$updated_credit."' where id='".$_POST['clientId']."'";
		$resultupdate = mysqli_query($connection,$update_credit);
		
	// }
	// else {
		// $message = "invalid data";
	// }
}
*/
?>
<div class="main-content">
<div class="section__content section__content--p30 page_mid">
<div class="container-fluid">
<div class="row">
<div class="col-md-12">
<div class="overview-wrap">
<h2 class="title-1"> User ADD Country <span style="margin-left:50px;"></span></h2>
<div class="table-data__tool-right">
<a href="users.php">
<button class="au-btn au-btn-icon au-btn--green au-btn--small">
<i class="fa fa-eye" aria-hidden="true"></i> User</button></a>
</div>

</div>
</div>
</div>

<div class="big_live_outer">
<div class="row">
    <div class="col-md-12">
        <div class="queue_info">
            <form id="userForm" action="#" name="countryadd" method="post">
                


<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">User Name</label>
</div>
<div class="col-12 col-md-9">
<select id="clientId"  data-show-subtext="false" data-live-search="true" name="clientId" class="form-control selectpicker">
<option value="0" selected="selected">Select</option>
<?php while($rowss = mysqli_fetch_array($result_user)) { ?>
<option value="<?php echo $rowss['id']; ?>"><?php echo $rowss['name']; ?></option>
<?php } ?>
</select>
</div>
</div>



<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Add Country</label>
</div>
<div class="col-12 col-md-9">
<select id="name" name="name" class="form-control">
<option value="0">Select</option>

<option value="93">Afghanistan</option>

<option value="355">Albania</option>

<option value="213">Algeria</option>

<option value="684">American Samoa</option>

<option value="376">Andorra</option>

<option value="244">Angola</option>

<option value="1264">Anguilla</option>

<option value="672">Antarctica</option>

<option value="1268">Antigua And Barbuda</option>

<option value="54">Argentina</option>

<option value="374">Armenia</option>

<option value="297">Aruba</option>

<option value="61">Australia</option>

<option value="43">Austria</option>

<option value="994">Azerbaijan</option>

<option value="1242">Bahamas</option>

<option value="973">Bahrain</option>

<option value="880">Bangladesh</option>

<option value="1246">Barbados</option>

<option value="375">Belarus</option>

<option value="32">Belgium</option>

<option value="501">Belize</option>

<option value="229">Benin</option>

<option value="1441">Bermuda</option>

<option value="975">Bhutan</option>

<option value="591">Bolivia</option>

<option value="387">Bosnia And Herzegovina</option>

<option value="267">Botswana</option>

<option value="0">Bouvet Island</option>

<option value="55">Brazil</option>

<option value="1284">British Indian Ocean Territory</option>

<option value="673">Brunei Darussalam</option>

<option value="359">Bulgaria</option>

<option value="226">Burkina Faso</option>

<option value="257">Burundi</option>

<option value="855">Cambodia</option>

<option value="237">Cameroon</option>

<option value="1">Canada</option>

<option value="238">Cape Verde</option>

<option value="1345">Cayman Islands</option>

<option value="236">Central African Republic</option>

<option value="235">Chad</option>

<option value="56">Chile</option>

<option value="86">China</option>

<option value="618">Christmas Island</option>

<option value="61">Cocos (Keeling); Islands</option>

<option value="57">Colombia</option>

<option value="269">Comoros</option>

<option value="242">Congo</option>

<option value="243">Congo, The Democratic Republic Of The</option>

<option value="682">Cook Islands</option>

<option value="506">Costa Rica</option>

<option value="385">Croatia</option>

<option value="53">Cuba</option>

<option value="357">Cyprus</option>

<option value="420">Czech Republic</option>

<option value="45">Denmark</option>

<option value="253">Djibouti</option>

<option value="1767">Dominica</option>

<option value="1809">Dominican Republic</option>

<option value="593">Ecuador</option>

<option value="20">Egypt</option>

<option value="503">El Salvador</option>

<option value="240">Equatorial Guinea</option>

<option value="291">Eritrea</option>

<option value="372">Estonia</option>

<option value="251">Ethiopia</option>

<option value="500">Falkland Islands (Malvinas);</option>

<option value="298">Faroe Islands</option>

<option value="679">Fiji</option>

<option value="358">Finland</option>

<option value="33">France</option>

<option value="596">French Guiana</option>

<option value="594">French Polynesia</option>

<option value="689">French Southern Territories</option>

<option value="241">Gabon</option>

<option value="220">Gambia</option>

<option value="995">Georgia</option>

<option value="49">Germany</option>

<option value="233">Ghana</option>

<option value="350">Gibraltar</option>

<option value="30">Greece</option>

<option value="299">Greenland</option>

<option value="1473">Grenada</option>

<option value="590">Guadeloupe</option>

<option value="1671">Guam</option>

<option value="502">Guatemala</option>

<option value="224">Guinea</option>

<option value="245">Guinea-Bissau</option>

<option value="592">Guyana</option>

<option value="509">Haiti</option>

<option value="0">Heard Island And McDonald Islands</option>

<option value="0">Holy See (Vatican City State);</option>

<option value="504">Honduras</option>

<option value="852">Hong Kong</option>

<option value="36">Hungary</option>

<option value="354">Iceland</option>

<option value="91">India</option>

<option value="62">Indonesia</option>

<option value="98">Iran, Islamic Republic Of</option>

<option value="964">Iraq</option>

<option value="353">Ireland</option>

<option value="972">Israel</option>

<option value="39">Italy</option>

<option value="1876">Jamaica</option>

<option value="81">Japan</option>

<option value="962">Jordan</option>

<option value="7">Kazakhstan</option>

<option value="254">Kenya</option>

<option value="686">Kiribati</option>

<option value="850">Korea, Democratic People's Republic Of</option>

<option value="82">Korea, Republic of</option>

<option value="965">Kuwait</option>

<option value="996">Kyrgyzstan</option>

<option value="856">Lao People's Democratic Republic</option>

<option value="371">Latvia</option>

<option value="961">Lebanon</option>

<option value="266">Lesotho</option>

<option value="231">Liberia</option>

<option value="218">Libyan Arab Jamahiriya</option>

<option value="423">Liechtenstein</option>

<option value="370">Lithuania</option>

<option value="352">Luxembourg</option>

<option value="853">Macao</option>

<option value="389">Macedonia, The Former Yugoslav Republic Of</option>

<option value="261">Madagascar</option>

<option value="265">Malawi</option>

<option value="60">Malaysia</option>

<option value="960">Maldives</option>

<option value="223">Mali</option>

<option value="356">Malta</option>

<option value="692">Marshall islands</option>

<option value="596">Martinique</option>

<option value="222">Mauritania</option>

<option value="230">Mauritius</option>

<option value="269">Mayotte</option>

<option value="52">Mexico</option>

<option value="691">Micronesia, Federated States Of</option>

<option value="1808">Moldova, Republic Of</option>

<option value="377">Monaco</option>

<option value="976">Mongolia</option>

<option value="1664">Montserrat</option>

<option value="212">Morocco</option>

<option value="258">Mozambique</option>

<option value="95">Myanmar</option>

<option value="264">Namibia</option>

<option value="674">Nauru</option>

<option value="977">Nepal</option>

<option value="31">Netherlands</option>

<option value="599">Netherlands Antilles</option>

<option value="687">New Caledonia</option>

<option value="64">New Zealand</option>

<option value="505">Nicaragua</option>

<option value="227">Niger</option>

<option value="234">Nigeria</option>

<option value="683">Niue</option>

<option value="672">Norfolk Island</option>

<option value="1670">Northern Mariana Islands</option>

<option value="47">Norway</option>

<option value="968">Oman</option>

<option value="92">Pakistan</option>

<option value="680">Palau</option>

<option value="970">Palestinian Territory, Occupied</option>

<option value="507">Panama</option>

<option value="675">Papua New Guinea</option>

<option value="595">Paraguay</option>

<option value="51">Peru</option>

<option value="63">Philippines</option>

<option value="0">Pitcairn</option>

<option value="48">Poland</option>

<option value="351">Portugal</option>

<option value="1787">Puerto Rico</option>

<option value="974">Qatar</option>

<option value="262">Reunion</option>

<option value="40">Romania</option>

<option value="7">Russian Federation</option>

<option value="250">Rwanda</option>

<option value="290">SaINT Helena</option>

<option value="1869">SaINT Kitts And Nevis</option>

<option value="1758">SaINT Lucia</option>

<option value="508">SaINT Pierre And Miquelon</option>

<option value="1784">SaINT Vincent And The Grenadines</option>

<option value="685">Samoa</option>

<option value="378">San Marino</option>

<option value="239">SÃ£o TomÃ© And Principe</option>

<option value="966">Saudi Arabia</option>

<option value="221">Senegal</option>

<option value="248">Seychelles</option>

<option value="232">Sierra Leone</option>

<option value="65">Singapore</option>

<option value="421">Slovakia</option>

<option value="386">Slovenia</option>

<option value="677">Solomon Islands</option>

<option value="252">Somalia</option>

<option value="27">South Africa</option>

<option value="0">South Georgia And The South Sandwich Islands</option>

<option value="34">Spain</option>

<option value="94">Sri Lanka</option>

<option value="249">Sudan</option>

<option value="597">Suriname</option>

<option value="0">Svalbard and Jan Mayen</option>

<option value="268">Swaziland</option>

<option value="46">Sweden</option>

<option value="41">Switzerland</option>

<option value="963">Syrian Arab Republic</option>

<option value="886">Taiwan, Province Of China</option>

<option value="992">Tajikistan</option>

<option value="255">Tanzania, United Republic Of</option>

<option value="66">Thailand</option>

<option value="670">Timor-Leste</option>

<option value="228">Togo</option>

<option value="690">Tokelau</option>

<option value="676">Tonga</option>

<option value="1868">Trinidad And Tobago</option>

<option value="216">Tunisia</option>

<option value="90">Turkey</option>

<option value="993">Turkmenistan</option>

<option value="1649">Turks And Caicos Islands</option>

<option value="688">Tuvalu</option>

<option value="256">Uganda</option>

<option value="380">Ukraine</option>

<option value="971">United Arab Emirates</option>

<option value="44">United Kingdom</option>

<option value="1">United States</option>

<option value="0">United States Minor Outlying Islands</option>

<option value="598">Uruguay</option>

<option value="998">Uzbekistan</option>

<option value="678">Vanuatu</option>

<option value="58">Venezuela</option>

<option value="84">Vietnam</option>

<option value="1284">Virgin Islands, British</option>

<option value="808">Virgin Islands, U.S.</option>

<option value="681">Wallis And Futuna</option>

<option value="0">Western Sahara</option>

<option value="967">Yemen</option>

<option value="0">Yugoslavia</option>

<option value="260">Zambia</option>

<option value="263">Zimbabwe</option>

<option value="0">Ascension Island</option>

<option value="0">Diego Garcia</option>

<option value="0">Inmarsat</option>

<option value="0">East timor</option>

<option value="0">Alaska</option>

<option value="0">Hawaii</option>

<option value="225">CÃ´te d'Ivoire</option>

<option value="35818">Aland Islands</option>

<option value="0">Saint Barthelemy</option>

<option value="441481">Guernsey</option>

<option value="441624">Isle of Man</option>

<option value="441534">Jersey</option>

<option value="0">Saint Martin</option>

<option value="382">Montenegro, Republic of</option>

<option value="381">Serbia, Republic of</option>

<option value="0">Clipperton Island</option>

<option value="0">Tristan da Cunha</option>

<option value="381">Kosovo</option>

</select>
</div>
</div>


			
			<div class="form-group pull-right">
			 <button type="submit" class="btn btn-primary btn-sm">Submit</button>
			</div>
			
</form>
			
        </div>
		
		
	
    </div>
	
	<div>
		<div class="col-md-12">
		<ul class="tfn_list country_tfn_list">
	   
    </ul>
	</div>
	</div>
	
    </div>



</div>




</div>



</div>
<!-- footer section start here -->
<!-- <div class="copyright">
<p>Copyright Â© 2020 PBX. All rights reserved.</p>
</div> -->
<!-- footer section end here -->

</div>
</div>


<?php require_once('footer.php'); ?> 
 
