<?php require_once('header.php'); 

?>

<div class="main-content">
<div class="section__content section__content--p30 page_mid">
<div class="container-fluid">
<div class="row">
<div class="col-md-12">
<div class="overview-wrap">
   
 <h2 class="title-1"> Classic Report </h2>    

</div>
</div>
</div>

<div class="reports_inner_outer">
<div class="row">
    <div class="col-md-12">
        <div class="classic_queue_info">
            <form id="classicReportForm" action="" method="post">
            <div class="row">

<div class="col-md-4">
  <div class="form-group">
    <label for="text-input" class=" form-control-label">From Date</label>
      <input id="fromDate" name="fromDate" class="form-control" type="text" value="2021-09-23"/>
   </div>
</div>

<div class="col-md-4">
<div class="form-group">
<label for="text-input" class=" form-control-label">Hours From*</label>
<select id="hoursFrom" name="hoursFrom" class="form-control"><option value="00" selected="selected">00</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option></select>
</div>
</div>

<div class="col-md-4">
<div class="form-group">
<label for="text-input" class=" form-control-label">Minutes From*</label>
<select id="minutesFrom" name="minutesFrom" class="form-control"><option value="00" selected="selected">00</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option><option value="32">32</option><option value="33">33</option><option value="34">34</option><option value="35">35</option><option value="36">36</option><option value="37">37</option><option value="38">38</option><option value="39">39</option><option value="40">40</option><option value="41">41</option><option value="42">42</option><option value="43">43</option><option value="44">44</option><option value="45">45</option><option value="46">46</option><option value="47">47</option><option value="48">48</option><option value="49">49</option><option value="50">50</option><option value="51">51</option><option value="52">52</option><option value="53">53</option><option value="54">54</option><option value="55">55</option><option value="56">56</option><option value="57">57</option><option value="58">58</option><option value="59">59</option></select>
</div>
</div>

<div class="col-md-4">
<div class="form-group">
<label for="text-input" class=" form-control-label">To Date</label>
<input id="toDate" name="toDate" class="form-control" type="text" value="2021-09-23"/>
</div>
</div>

<div class="col-md-4">
<div class="form-group">
<label for="text-input" class=" form-control-label">Hours To*</label>
<select id="hoursTo" name="hoursTo" class="form-control"><option value="00" selected="selected">00</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option></select>
</div>
</div>

<div class="col-md-4">
<div class="form-group">
<label for="text-input" class=" form-control-label">Minutes To*</label>
<select id="minutesTo" name="minutesTo" class="form-control"><option value="00" selected="selected">00</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option><option value="32">32</option><option value="33">33</option><option value="34">34</option><option value="35">35</option><option value="36">36</option><option value="37">37</option><option value="38">38</option><option value="39">39</option><option value="40">40</option><option value="41">41</option><option value="42">42</option><option value="43">43</option><option value="44">44</option><option value="45">45</option><option value="46">46</option><option value="47">47</option><option value="48">48</option><option value="49">49</option><option value="50">50</option><option value="51">51</option><option value="52">52</option><option value="53">53</option><option value="54">54</option><option value="55">55</option><option value="56">56</option><option value="57">57</option><option value="58">58</option><option value="59">59</option></select>
</div>
</div>

<div class="col-md-4">
<div class="form-group">
<label for="text-input" class=" form-control-label">Disposition</label>
<select id="disposition" name="disposition" class="form-control">
<option value="All" selected="selected">All</option>
<option value="ANSWERED">ANSWERED</option>
<option value="BUSY">BUSY</option>
<option value="FAILED">FAILED</option>
<option value="NO ANSWER">NO ANSWER</option>
<option value="ABANDON">ABANDON</option>
</select>
</div>
</div>

<div class="col-md-4">
<div class="form-group">
<label for="text-input" class=" form-control-label">Call Type</label>
<select id="call_type" name="call_type" class="form-control">
<option value="All" selected="selected">All</option>
<option value="Inbound">Inbound</option>
<option value="Outbound">Outbound</option>

</select>
</div>
</div>

<div class="col-md-4">
<div class="form-group">
<label for="text-input" class=" form-control-label">Queue Name</label>
<select id="queueName" name="queueName" class="form-control">

<option value="All" selected="selected">All</option>



<option value=" 0001"> 0001</option>

<option value="0002">0002</option>

<option value="0003">0003</option>

<option value="0004">0004</option>

<option value="0005">0005</option>

<option value="0006">0006</option>

<option value="0007">0007</option>

<option value="0008">0008</option>

<option value="80001">80001</option>

<option value="5001">5001</option>

<option value="2001">2001</option>

<option value="2002">2002</option>

<option value="0009">0009</option>

<option value="00011">00011</option>

<option value="5526">5526</option>

<option value="9120">9120</option>

<option value="00780">00780</option>

<option value="99001">99001</option>

<option value="00001">00001</option>

<option value="5506">5506</option>

<option value="5532">5532</option>

<option value="550051">550051</option>

<option value="8000">8000</option>

<option value="900221">900221</option>

<option value="10000">10000</option>

<option value="72900">72900</option>

<option value="0055">0055</option>

</select>
</div>
</div>

<div class="col-md-4">
<div class="form-group">
<label for="text-input" class=" form-control-label">Extension</label>
<select id="extension" name="extension" class="form-control">
<option value="All" selected="selected">All</option>

<option value="202">202</option>

<option value="001">001</option>

<option value="201">201</option>

<option value="304">304</option>

<option value="302">302</option>

<option value="32474">32474</option>

<option value="05484">05484</option>

<option value="301">301</option>

<option value="303">303</option>

<option value="305">305</option>

<option value="306">306</option>

<option value="203">203</option>

<option value="204">204</option>

<option value="205">205</option>

<option value="206">206</option>

<option value="207">207</option>

<option value="69369">69369</option>

<option value="208">208</option>

<option value="209">209</option>

<option value="002">002</option>

<option value="619">619</option>

<option value="003">003</option>

<option value="401">401</option>

<option value="213">213</option>

<option value="601">601</option>

<option value="602">602</option>

<option value="604">604</option>

<option value="605">605</option>

<option value="612">612</option>

<option value="607">607</option>

<option value="609">609</option>

<option value="300">300</option>

<option value="200">200</option>

<option value="211">211</option>

<option value="101">101</option>

<option value="102">102</option>

<option value="103">103</option>

<option value="104">104</option>

<option value="105">105</option>

<option value="623">623</option>

<option value="106">106</option>

<option value="108">108</option>

<option value="882">882</option>

<option value="5002">5002</option>

<option value="5003">5003</option>

<option value="709">709</option>

<option value="004">004</option>

<option value="402">402</option>

<option value="6758587574123131">6758587574123131</option>

<option value="617">617</option>

<option value="212">212</option>

<option value="214">214</option>

<option value="215">215</option>

<option value="221">221</option>

<option value="222">222</option>

<option value="503">503</option>

<option value="109">109</option>

<option value="710">710</option>

<option value="703">703</option>

<option value="705">705</option>

<option value="801">801</option>

<option value="802">802</option>

<option value="803">803</option>

<option value="804">804</option>

<option value="805">805</option>

<option value="806">806</option>

<option value="807">807</option>

<option value="700">700</option>

<option value="800">800</option>

<option value="809">809</option>

<option value="100">100</option>

<option value="707">707</option>

<option value="712">712</option>

<option value="403">403</option>

<option value="404">404</option>

<option value="620">620</option>

<option value="405">405</option>

<option value="406">406</option>

<option value="407">407</option>

<option value="408">408</option>

<option value="409">409</option>

<option value="902">902</option>

<option value="901">901</option>

<option value="900">900</option>

<option value="1101">1101</option>

<option value="502">502</option>

<option value="600">600</option>

<option value="400">400</option>

<option value="500">500</option>

<option value="110">110</option>

<option value="613">613</option>

<option value="616">616</option>

<option value="307">307</option>

<option value="309">309</option>

<option value="308">308</option>

<option value="310">310</option>

<option value="311">311</option>

<option value="501">501</option>

<option value="610">610</option>

<option value="233">233</option>

<option value="9901">9901</option>

<option value="708">708</option>

<option value="614">614</option>

<option value="808">808</option>

<option value="711">711</option>

<option value="508">508</option>

<option value="507">507</option>

<option value="9902">9902</option>

<option value="506">506</option>

<option value="628">628</option>

<option value="622">622</option>

<option value="999991">999991</option>

<option value="615">615</option>

<option value="504">504</option>

<option value="505">505</option>

<option value="45868">45868</option>

<option value="625">625</option>

<option value="666">666</option>

<option value="509">509</option>

<option value="315">315</option>

<option value="316">316</option>

<option value="317">317</option>

<option value="318">318</option>

<option value="319">319</option>

<option value="618">618</option>

<option value="55102">55102</option>

<option value="55101">55101</option>

<option value="883">883</option>

<option value="624">624</option>

<option value="216">216</option>

<option value="814">814</option>

<option value="006">006</option>

<option value="8812">8812</option>

<option value="220">220</option>

<option value="888">888</option>

<option value="621">621</option>

<option value="626">626</option>

<option value="232">232</option>

<option value="811">811</option>

<option value="217">217</option>

<option value="636">636</option>

<option value="887">887</option>

<option value="813">813</option>

<option value="812">812</option>

<option value="884">884</option>

<option value="22515">22515</option>

<option value="005">005</option>

<option value="111">111</option>

<option value="642">642</option>

<option value="640">640</option>

<option value="816">816</option>

<option value="627">627</option>

<option value="815">815</option>

<option value="634">634</option>

<option value="886">886</option>

<option value="113">113</option>

<option value="23160">23160</option>

<option value="632">632</option>

<option value="629">629</option>

<option value="630">630</option>

<option value="112">112</option>

<option value="30864">30864</option>

<option value="881">881</option>

<option value="230">230</option>

<option value="885">885</option>

<option value="8811">8811</option>

<option value="635">635</option>

<option value="551">551</option>

<option value="8813">8813</option>

<option value="889">889</option>

<option value="8814">8814</option>

<option value="644">644</option>

<option value="231">231</option>

<option value="550">550</option>

<option value="631">631</option>

<option value="633">633</option>

<option value="552">552</option>

<option value="218">218</option>

<option value="234">234</option>

<option value="9898">9898</option>

<option value="637">637</option>

<option value="638">638</option>

<option value="6677">6677</option>

<option value="114">114</option>

<option value="7788">7788</option>

<option value="641">641</option>

<option value="639">639</option>

<option value="554">554</option>

<option value="989898">989898</option>

<option value="643">643</option>

<option value="219">219</option>

<option value="645">645</option>

<option value="223">223</option>

<option value="12873">12873</option>

<option value="646">646</option>

<option value="553">553</option>

<option value="649">649</option>

<option value="235">235</option>

<option value="236">236</option>

<option value="237">237</option>

<option value="238">238</option>

<option value="239">239</option>

<option value="555">555</option>

<option value="648">648</option>

<option value="647">647</option>

<option value="650">650</option>

</select>
</div>
</div>

<div class="col-md-4">
<div class="form-group">
<label for="text-input" class=" form-control-label">TFN</label>
<select id="DID" name="DID" class="form-control">
<option value="All" selected="selected">All</option>

<option value="+917669138652">+917669138652</option>

<option value="+918929059550">+918929059550</option>

<option value="15402428692">15402428692</option>

<option value="+918869023049">+918869023049</option>

<option value="18775448770">18775448770</option>

<option value="+918929059544">+918929059544</option>

<option value="+918929170419">+918929170419</option>

<option value="+918929170408">+918929170408</option>

<option value="+918929170412">+918929170412</option>

<option value="+918929059541">+918929059541</option>

<option value="+918929170418">+918929170418</option>

<option value="+918929693279">+918929693279</option>

<option value="+917669138649">+917669138649</option>

<option value="+918929059538">+918929059538</option>

<option value="+918929979903">+918929979903</option>

<option value="+918178502885">+918178502885</option>

<option value="+917291994419">+917291994419</option>

<option value="+917669032736">+917669032736</option>

<option value="+918958415305">+918958415305</option>

<option value="+919560658513">+919560658513</option>

<option value="19177225031">19177225031</option>

<option value="8883241948">8883241948</option>

<option value="6531592229">6531592229</option>

<option value="6531591398">6531591398</option>

<option value="6531592414">6531592414</option>

<option value="6531592430">6531592430</option>

<option value="6531594273">6531594273</option>

<option value="6531594241">6531594241</option>

<option value="6531592439">6531592439</option>

<option value="6531592443">6531592443</option>

<option value="6531591601">6531591601</option>

<option value="+918929170416">+918929170416</option>

<option value="+918929170415">+918929170415</option>

<option value="+917669017792">+917669017792</option>

<option value="+919354139524">+919354139524</option>

<option value="+919354139476">+919354139476</option>

<option value="+918929170407">+918929170407</option>

<option value="+918076294733">+918076294733</option>

<option value="+918929170413">+918929170413</option>

<option value="+918929170405">+918929170405</option>

<option value="+918929170414">+918929170414</option>

<option value="+918595746168">+918595746168</option>

<option value="+918595745385">+918595745385</option>

<option value="+917827048933">+917827048933</option>

<option value="+918076295886">+918076295886</option>

<option value="+919289131406">+919289131406</option>

<option value="+918506010777">+918506010777</option>

<option value="+917834963322">+917834963322</option>

<option value="+919910832415">+919910832415</option>

<option value="+919873633500">+919873633500</option>

<option value="61280735033">61280735033</option>

<option value="61280735055">61280735055</option>

<option value="+918929170411">+918929170411</option>

<option value="+919654359912">+919654359912</option>

<option value="+919015153831">+919015153831</option>

<option value="+919560806002">+919560806002</option>

<option value="17032978855">17032978855</option>

<option value="18024008801">18024008801</option>

<option value="16172755603">16172755603</option>

<option value="16178302225">16178302225</option>

<option value="16076056383">16076056383</option>

<option value="18573499080">18573499080</option>

<option value="18573552033">18573552033</option>

<option value="6531592242">6531592242</option>

<option value="18573552048">18573552048</option>

<option value="12402611090">12402611090</option>

<option value="18574195499">18574195499</option>

<option value="12402497865">12402497865</option>

<option value="12406171663">12406171663</option>

<option value="16172755586">16172755586</option>

<option value="18028018800">18028018800</option>

<option value="1617275586">1617275586</option>

<option value="12403634353">12403634353</option>

<option value="6531592220">6531592220</option>

<option value="18449013001">18449013001</option>

<option value="+917669032737">+917669032737</option>

<option value="+917669032744">+917669032744</option>

<option value="+917669032743">+917669032743</option>

<option value="+917669032742">+917669032742</option>

<option value="+918929170410">+918929170410</option>

<option value="6531591296">6531591296</option>

<option value="6531591284">6531591284</option>

<option value="12408238887">12408238887</option>

<option value="6531591234">6531591234</option>

<option value="6531591209">6531591209</option>

<option value="6531591391">6531591391</option>

<option value="6531591790">6531591790</option>

<option value="6531592356">6531592356</option>

<option value="442037692049">442037692049</option>

<option value="442037690986">442037690986</option>

<option value="442037690829">442037690829</option>

<option value="12408013250">12408013250</option>

<option value="12408001808">12408001808</option>

<option value="12407022444">12407022444</option>

<option value="12406162370">12406162370</option>

<option value="12405129866">12405129866</option>

<option value="+918447512644">+918447512644</option>

<option value="18573552049">18573552049</option>

<option value="18882591905">18882591905</option>

<option value="12402194420">12402194420</option>

<option value="18044097008">18044097008</option>

<option value="14084132410">14084132410</option>

<option value="18002819192">18002819192</option>

<option value="18448894054">18448894054</option>

<option value="6531591221">6531591221</option>

<option value="+918010000200">+918010000200</option>

<option value="+918585858585">+918585858585</option>

<option value="+918888888888">+918888888888</option>

<option value="+912222222222">+912222222222</option>

<option value="6531595749">6531595749</option>

<option value="+911111111111">+911111111111</option>

<option value="6531592354">6531592354</option>

<option value="18886255718">18886255718</option>

<option value="18574195500">18574195500</option>

<option value="+919811812666">+919811812666</option>

<option value="6531592433">6531592433</option>

<option value="8887454710">8887454710</option>

<option value="6531595336">6531595336</option>

<option value="6531594540">6531594540</option>

<option value="6531595339">6531595339</option>

<option value="6531591144">6531591144</option>

<option value="+917669010738">+917669010738</option>

<option value="442037690799">442037690799</option>

<option value="442037690796">442037690796</option>

<option value="18022325030">18022325030</option>

<option value="18022325015">18022325015</option>

<option value="18028002829">18028002829</option>

<option value="19495020092">19495020092</option>

<option value="6531591123">6531591123</option>

<option value="011442037694076">011442037694076</option>

<option value="6531588337">6531588337</option>

<option value="6531594067">6531594067</option>

<option value="6531594213">6531594213</option>

<option value="61280734485">61280734485</option>

<option value="61280734465">61280734465</option>

<option value="61280734442">61280734442</option>

<option value="6531594360">6531594360</option>

<option value="6531595332">6531595332</option>

<option value="12408062180">12408062180</option>

<option value="6531595337">6531595337</option>

<option value="17342704221">17342704221</option>

<option value="15205829673">15205829673</option>

<option value="12407542715">12407542715</option>

<option value="447418352269">447418352269</option>

<option value="+919717808665">+919717808665</option>

<option value="011442038077640">011442038077640</option>

<option value="+917669010749">+917669010749</option>

<option value="+917669010737">+917669010737</option>

<option value="+917669010741">+917669010741</option>

<option value="+917669010744">+917669010744</option>

<option value="+917669010748">+917669010748</option>

<option value="447418355618">447418355618</option>

<option value="447418355638">447418355638</option>

<option value="447418355494">447418355494</option>

<option value="6531591274">6531591274</option>

<option value="+917669010742">+917669010742</option>

<option value="6531595184">6531595184</option>

<option value="6531595083">6531595083</option>

<option value="6531592453">6531592453</option>

<option value=" 6531591826"> 6531591826</option>

<option value="6531591847">6531591847</option>

<option value="+917669010745">+917669010745</option>

<option value="6531594612">6531594612</option>

<option value="18023483888">18023483888</option>

<option value="18888689999">18888689999</option>

<option value="6531595542">6531595542</option>

<option value="6531592418">6531592418</option>

<option value="+918178522974">+918178522974</option>

<option value="447418350825">447418350825</option>

<option value="6531595325">6531595325</option>

<option value="6531595094">6531595094</option>

<option value="6531595004">6531595004</option>

<option value="19177225032">19177225032</option>

<option value="+917669032740">+917669032740</option>

<option value="+917669470846">+917669470846</option>

<option value="6531593482">6531593482</option>

<option value="6531595057">6531595057</option>

<option value="6531592271">6531592271</option>

<option value="447418352278">447418352278</option>

<option value="447418350291">447418350291</option>

<option value="447418353532">447418353532</option>

<option value="19177225033">19177225033</option>

<option value="6531592379">6531592379</option>

<option value="6531592419">6531592419</option>

<option value="+917669470833">+917669470833</option>

<option value="+917669470832">+917669470832</option>

<option value="19177225034">19177225034</option>

<option value="19177225035">19177225035</option>

<option value="61871705097">61871705097</option>

<option value="61280155153">61280155153</option>

<option value="6531591884">6531591884</option>

<option value="6531593483">6531593483</option>

<option value="6531595523">6531595523</option>

<option value="447520644206">447520644206</option>

<option value="6531595525">6531595525</option>

<option value="6531595536">6531595536</option>

<option value="6531595494">6531595494</option>

<option value="6531595564">6531595564</option>

<option value="+919903272011">+919903272011</option>

<option value="6531595546">6531595546</option>

<option value="6531595514">6531595514</option>

<option value="6531595543">6531595543</option>

<option value="6531595562">6531595562</option>

<option value="6531595530">6531595530</option>

<option value="6531595508">6531595508</option>

<option value="6531595744">6531595744</option>

<option value="+917669470836">+917669470836</option>

<option value="+917669662055">+917669662055</option>

<option value="6531650815">6531650815</option>

<option value="6531595718">6531595718</option>

<option value="6531650814">6531650814</option>

<option value="6531652427">6531652427</option>

<option value="6531652428">6531652428</option>

<option value="6531595735">6531595735</option>

<option value="6531652429">6531652429</option>

<option value="6531652869">6531652869</option>

<option value="6531652870">6531652870</option>

<option value="6531652871">6531652871</option>

<option value="6531652873">6531652873</option>

<option value="6531595727">6531595727</option>

<option value="6531652885">6531652885</option>

<option value="918726645554">918726645554</option>

<option value="61251335877">61251335877</option>

<option value="+9198107 95767">+9198107 95767</option>

<option value="61251335878">61251335878</option>

<option value="+917290063346">+917290063346</option>

<option value="+917290063345">+917290063345</option>

<option value="+919599142575">+919599142575</option>

<option value="44750644206">44750644206</option>

<option value="6531656255">6531656255</option>

<option value="6531656256">6531656256</option>

<option value="61251335879">61251335879</option>

<option value="+919810795767">+919810795767</option>

<option value="6531656897">6531656897</option>

<option value="6531656901">6531656901</option>

<option value="6531656902">6531656902</option>

<option value="6531656906">6531656906</option>

<option value="6531656907">6531656907</option>

<option value="6531656910">6531656910</option>

<option value="6531656257">6531656257</option>

<option value="6531656268">6531656268</option>

<option value="18023918220">18023918220</option>

<option value="6531656957">6531656957</option>

<option value="61251335880">61251335880</option>

<option value="6531656958">6531656958</option>

<option value="61281034103">61281034103</option>

<option value="61281034105">61281034105</option>

<option value="61281034108">61281034108</option>

<option value="61281034113">61281034113</option>

<option value="61281034114">61281034114</option>

<option value="6531656959">6531656959</option>

<option value="6531656960">6531656960</option>

</select>
</div>
</div>

<div class="col-md-4">
<div class="form-group">
<label for="text-input" class=" form-control-label">Caller ID</label>
<input id="CLID" name="CLID" class="form-control" type="text" value=""/>
</div>
</div>

<div class="col-md-4">
<div class="form-group">
<label for="text-input" class=" form-control-label">Dialed No.</label>
<input id="DNID" name="DNID" class="form-control" type="text" value=""/>
</div>
</div>
			<div class="col-md-3">
			<div class="form-group">
			 <button type="submit" style="margin-top: 38px;" class="btn btn-primary btn-sm">Submit</button>
			</div>
        </div>
			<p></p>

        </div>	
</form>
			
			
			
        </div>
    </div>
    </div>
</div>

<!-- the code will write here i left the office for now boz raining today 23 sept 2021 -->

</div>


</div>
</div>

<?php require_once('footer.php'); ?> 
 
