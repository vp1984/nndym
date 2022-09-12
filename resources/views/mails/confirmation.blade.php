<!doctype html>
<html style="margin: 0;">
   <head>
      <meta charset="utf-8">
      <title>Want a Santa</title>
   </head>
   <body style="margin: 0;">
      <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin: 0;">
         <tbody>
            <tr>
               <td>
                  <table width="710px" border="0" cellspacing="0" cellpadding="0">
                     <tbody>
                        <tr>
                           <td><img style="display: block;width: 794px; height: 400px;" src="http://www.wantasanta.com/mailers/confirmation-mailer/confirmation-pdf-header.jpg"></td>
                        </tr>
                        <tr>
                           <td bgcolor="#d8382c">&nbsp;</td>
                        </tr>
                        <tr>
                           <td bgcolor="#d8382c" style="padding: 0 40px 40px 40px; text-align: left; font-family: Arial, Helvetica, sans-serif; font-size: 14px; line-height: 20px; color: #ffffff;">Dear {{$orderDetails->guardian_name}},<br><br>We are delighted to confirm your booking with us. Our representative shall get in touch 24 hours before the scheduled visit.</td>
                        </tr>
                        <tr>
                           <td bgcolor="#d8382c">
                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                 <tbody>
                                    <tr>
                                       <td width="50%" style="padding-left: 105px;"><img src="http://www.wantasanta.com/mailers/confirmation-mailer/booking-summary.jpg"></td>
                                       <td width="50%" style="padding-left:10px; text-align: left; font-family: Arial, Helvetica, sans-serif; font-size: 14px; font-weight:bold; line-height: 20px; color: #ffffff;">Booking ID {{$orderDetails->order_number}}</td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                        <tr>
                           <td bgcolor="#d8382c">&nbsp;</td>
                        </tr>
                        <tr>
                           <td bgcolor="#d8382c" style="padding:0 40px ;">
                              <table style="text-align:left; background-color:#D9DADA; border-radius: 10px; padding-left:5px; width:100%;" width="100%" border="0" cellspacing="0" cellpadding="0">
                                 <tr>
                                    <td style="padding:8px; font-size:14px; font-family:'arial', sans-serif;">
                                       <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                             <td width="50%" style="padding:8px; font-weight:bold; font-size:14px; font-family:'arial', sans-serif;">Booking Details</td>
                                             <td width="50%" style="padding:8px; font-weight:bold; font-size:14px; font-family:'arial', sans-serif;">&nbsp;</td>
                                          </tr>
                                          <tr>
                                             <td style="padding:5px; font-size:14px; font-family:'arial', sans-serif;">Booking ID {{$orderDetails->order_number}}</td>
                                             <td style="padding:5px; font-size:14px; font-family:'arial', sans-serif;">{{$orderDetails->package_date}}  |  {{ucfirst($orderDetails->city_date_package)}}</td>
                                          </tr>
                                          <tr>
                                             <td style="padding:5px; font-size:14px; font-family:'arial', sans-serif;">{{$orderDetails->package}}</td>
                                             <td style="padding:5px; font-size:14px; font-family:'arial', sans-serif;">{{$orderDetails->area}}, {{$orderDetails->city}}</td>
                                          </tr>
                                          <tr>
                                             <td style="padding:5px; font-size:14px; font-family:'arial', sans-serif;">{{$orderDetails->kids}}</td>
                                             <td style="padding:5px; font-size:14px; font-family:'arial', sans-serif;">Booking Date: {{$orderDetails->created_at}}</td>
                                          </tr>
                                       </table>
                                    </td>
                                 </tr>
                              </table>
                           </td>
                        </tr>
                        <tr>
                           <td bgcolor="#d8382c" style="padding:0 40px ;">&nbsp;</td>
                        </tr>
                        <tr>
                           <td bgcolor="#d8382c" style="padding:0 40px ;">
                              <table style="text-align:left; background-color:#D9DADA; border-radius: 10px; padding-left:5px; width:100%;" width="100%" border="0" cellspacing="0" cellpadding="0">
                                 <tr>
                                    <td style="padding:8px; font-size:14px; font-family:'arial', sans-serif;">
                                       <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                             <td width="50%" style="padding:8px; padding-bottom:0; font-weight:bold; font-size:14px; font-family:'arial', sans-serif;">Package Inclusions </td>
                                          </tr>
                                          <tr>
                                             <td style="padding:5px; font-size:14px; font-family:'arial', sans-serif;">
                                                {!!$orderDetails->inclusion !!}
                                             </td>
                                          </tr>
                                       </table>
                                    </td>
                                 </tr>
                              </table>
                           </td>
                        </tr>
                        <tr>
                           <td bgcolor="#d8382c" style="padding:0 40px ;">&nbsp;</td>
                        </tr>
                        <tr>
                           <td bgcolor="#d8382c" style="padding:0 40px ;">&nbsp;</td>
                        </tr>
                        <tr>
                           <td bgcolor="#d8382c" style="padding:0 40px ;">
                              <table style="text-align:left; background-color:#D9DADA; border-radius: 10px; padding-left:5px; width:100%;" width="100%" border="0" cellspacing="0" cellpadding="0">
                                 <tr>
                                    <td style="padding:8px; font-size:14px; font-family:'arial', sans-serif;">
                                       <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                             <td width="50%" style="padding:8px; font-weight:bold; font-size:14px; font-family:'arial', sans-serif;">Guardian Details</td>
                                             <td width="50%" style="padding:8px; font-weight:bold; font-size:14px; font-family:'arial', sans-serif;">&nbsp;</td>
                                          </tr>
                                          <tr>
                                             <td style="padding:5px; font-size:14px; font-family:'arial', sans-serif;">{{$orderDetails->guardian_name}}</td>
                                             <td style="padding:5px; font-size:14px; font-family:'arial', sans-serif;">{{$orderDetails->guardian_email}}</td>
                                          </tr>
                                          <tr>
                                             <td style="padding:5px; font-size:14px; font-family:'arial', sans-serif;">{{$orderDetails->guardian_mobile}}</td>
                                             <td style="padding:5px; font-size:14px; font-family:'arial', sans-serif;">{{$orderDetails->guardian_alt_mobile}}</td>
                                          </tr>
                                          <tr>
                                             <td colspan="2" style="padding:5px; font-size:14px; font-family:'arial', sans-serif;">{{$orderDetails->guardian_address}}</td>
                                          </tr>
                                       </table>
                                    </td>
                                 </tr>
                              </table>
                           </td>
                        </tr>
                        <tr>
                           <td bgcolor="#d8382c" style="padding:0 40px ;">&nbsp;</td>
                        </tr>
                        <tr>
                           <td bgcolor="#d8382c" style="padding:0 40px ;">
                              <table style="text-align:left; background-color:#D9DADA; border-radius: 10px; padding-left:5px; width:100%;" width="100%" border="0" cellspacing="0" cellpadding="0">
                                 <tr>
                                    <td style="padding:8px; font-size:14px; font-family:'arial', sans-serif;">
                                       <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                             <td width="50%" style="padding:8px; font-weight:bold; font-size:14px; font-family:'arial', sans-serif;">Kids' Details</td>
                                             <td width="50%" style="padding:8px; font-weight:bold; font-size:14px; font-family:'arial', sans-serif;">&nbsp;</td>
                                          </tr>
                                          <tr>
                                             <td width="50%" style="padding:5px; font-size:14px; font-family:'arial', sans-serif; border-right:1px solid #000000;">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                   @if(isset($orderDetails->kidname) && !empty($orderDetails->kidname))
                                                   @php
                                                   $kidDetails = json_decode($orderDetails->kidname);
                                                   @endphp  
                                                   @endif
                                                   @foreach($kidDetails->kidname as $key=>$val)   
                                                   <tr>
                                                      <td style="padding:5px; font-size:14px; font-family:'arial', sans-serif;">{{ $kidDetails->kidname[$key] }}      {{ $kidDetails->kidage[$key].' Years' }}       {{ $kidDetails->kidgender[$key] }}</td>
                                                   </tr>
                                                   @endforeach  
                                                </table>
                                             </td>
                                          </tr>
                                       </table>
                                    </td>
                                 </tr>
                              </table>
                           </td>
                        </tr>
                        <tr>
                           <td bgcolor="#d8382c" style="padding:0 40px ;">&nbsp;</td>
                        </tr>
                        <tr>
                           <td bgcolor="#d8382c" style="padding:0 40px ;">
                              <table style="text-align:left; background-color:#D9DADA; border-radius: 10px; padding-left:5px; width:100%;" width="100%" border="0" cellspacing="0" cellpadding="0">
                                 <tr>
                                    <td style="padding:8px; font-size:14px; font-family:'arial', sans-serif;">
                                       <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                             <td width="50%" style="padding:8px; font-weight:bold; font-size:14px; font-family:'arial', sans-serif;">Gift</td>
                                          </tr>
                                          <tr>
                                             <td style="padding:5px; font-size:14px; font-family:'arial', sans-serif;">
                                                @if($orderDetails->choosedgift1 != '')
                                                {{$orderDetails->choosedgift1}}
                                                @endif                                                                                               
                                             </td>
                                          </tr>
                                          <tr>
                                             <td style="padding:5px; font-size:14px; font-family:'arial', sans-serif;">
                                                @if($orderDetails->choosedgift2 != '')
                                                {{$orderDetails->choosedgift2}}
                                                @endif                                                                                               
                                             </td>
                                          </tr>                                                                                 
                                       </table>
                                    </td>
                                 </tr>
                              </table>
                           </td>
                        </tr>
                        @if($orderDetails->special_message != '')
                        <tr>
                           <td bgcolor="#d8382c" style="padding:0 40px ;">&nbsp;</td>
                        </tr>
                        <tr>
                           <td bgcolor="#d8382c" style="padding:0 40px ;">
                              <table style="text-align:left; background-color:#D9DADA; border-radius: 10px; padding-left:5px; width:100%;" width="100%" border="0" cellspacing="0" cellpadding="0">
                                 <tr>
                                    <td style="padding:8px; font-size:14px; font-family:'arial', sans-serif;">
                                       <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                             <td width="50%" style="padding:8px; font-weight:bold; font-size:14px; font-family:'arial', sans-serif;">Special Message</td>
                                          </tr>                                         
                                          <tr>
                                             <td style="padding:5px; font-size:14px; font-family:'arial', sans-serif;">{{ $orderDetails->special_message }}</td>
                                          </tr>
                                       </table>
                                    </td>
                                 </tr>
                              </table>
                           </td>
                        </tr>  
                        @endif           
                        @if($orderDetails->special_instruction != '')           
                        <tr>
                           <td bgcolor="#d8382c" style="padding:0 40px ;">&nbsp;</td>
                        </tr>
                        <tr>
                           <td bgcolor="#d8382c" style="padding:0 40px ;">
                              <table style="text-align:left; background-color:#D9DADA; border-radius: 10px; padding-left:5px; width:100%;" width="100%" border="0" cellspacing="0" cellpadding="0">
                                 <tr>
                                    <td style="padding:8px; font-size:14px; font-family:'arial', sans-serif;">
                                       <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                             <td width="50%" style="padding:8px; font-weight:bold; font-size:14px; font-family:'arial', sans-serif;">Special Instruction</td>
                                          </tr>                                         
                                          <tr>
                                             <td style="padding:5px; font-size:14px; font-family:'arial', sans-serif;">{{ $orderDetails->special_instruction }}</td>
                                          </tr>
                                       </table>
                                    </td>
                                 </tr>
                              </table>
                           </td>
                        </tr>
                        @endif
                        <tr>
                           <td bgcolor="#d8382c" style="padding:0 40px ;">&nbsp;</td>
                        </tr>
                        <tr>
                           <td bgcolor="#d8382c" style="padding:0 40px ;">
                              <table style="text-align:left; background-color:#D9DADA; border-radius: 10px; padding-left:5px; width:100%;" width="100%" border="0" cellspacing="0" cellpadding="0">
                                 <tr>
                                    <td style="padding:8px; font-size:14px; font-family:'arial', sans-serif;">
                                       <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                             <td width="50%" style="padding:8px; font-weight:bold; font-size:14px; font-family:'arial', sans-serif;">Total amount paid: {{ $orderDetails->totalpriceamt }}</td>
                                          </tr>
                                       </table>
                                    </td>
                                 </tr>
                              </table>
                           </td>
                        <tr>
                           <td bgcolor="#d8382c" style="padding:0 40px ;">&nbsp;</td>
                        </tr>
                        <tr>
                           <td bgcolor="#d8382c" style="padding:0 40px ;">&nbsp;</td>
                        </tr>
                        <tr>
                        </tr>
                     </tbody>
                  </table>
               </td>
            </tr>
         </tbody>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
         <tbody>
            <tr>
               <td style="padding:20px 40px; font-weight:bold; font-size:12px; font-family:'arial', sans-serif;  word-break:break-all; word-wrap:break-word;">
                  <table width="680px" border="0" cellspacing="0" cellpadding="0">
                     <tbody>
                        <tr>
                           <td ">
                              <p><strong>General Notes</strong></p>
                              <ol style="font-weight:normal; text-align:justify; word-break:break-all; word-wrap:break-word; ">
                                 <li>All our offerings and assistance are specific for the children’s age up 12 years only.</li>
                                 <li><strong>Availability</strong> – We offer Specific packages which are available in specific cities restricted to specific areas with specific time-frame only as mentioned in the site. Prior to the booking kindly check the availability for the same.</li>
                                 <li><strong>Date and Time of the Visit</strong> – Kindly go through the availability of packages across the available date and time slots. We may not assure the exact preferred time of the visit, but will surely attempt to make the visit on the desired date and Time Slot selected. Our team shall get in touch with you within 24 hours before the visit and shall inform at least 30 minutes prior to the visit. In-case of any delay caused, the same shall be intimated to you in advance by our representative. </li>
                                 <li><strong>Duration</strong> – We believe in time bound performance and only to the number of beneficiaries who are already booked. Extension of time and number of beneficiaries during the visit shall not be entertained and the same is not allowed for whatsoever reason. In case if there is any extension of time or change in number of beneficiaries due to unforeseen or unavoidable circumstances it would attract additional cost, to be paid online immediately. </li>
                                 <li><strong>No Show</strong> – Incase if no one is present at the given venue or at the decided location, it will be treated as a no show, however, the booking shall be considered as cancelled and the 100% booking amount shall be forfeited.</li>
                                 <li><strong>Drive with Santa</strong> –Santa Drive will be restricted up to maximum 30 mins or 7 Kms (Total Distance Round Trip) including the time spent at your home. Any Guardian/parent must always accompany the children during the drive. You can instruct our chauffer about a route of your choice that seems appropriate keeping in mind the restriction of time and distance. You can take a small pitstop of your choice too. </li>
                                 <li><strong>Personalized Message by Santa</strong> - Parents or Guardians of kids can fill in the details under <strong>‘Personalized Message’</strong> section during the booking process and let us know about what they would like Santa to tell their children. Accordingly Santa would deliver the message during the visit and be the guiding voice for the children.</li>
                                 <li><strong>Surprise Gift</strong> – The surprise gift shall be for each kid as per the pre-booking. The surprise gifts are from our partner Mattel India, and it could be from any of the following brands; Barbie, Hot Wheels, Fisher-Price and Thomas & Friends. Please note that we shall carry gifts and other merchandise for only the number of kids already booked for. Additional gifts and merchandise shall not be available during visit. Gifts cannot be exchanged. </li>
                                 <li><strong>Choose gifts from our selection</strong> – We have specially curated some of the finest Toys for you to gift your children. The toys are available at special prices. The toy shall be delivered to your address separately before visit the date. You can on the day of the visit handover the toy to our Santa just before he enters the house.</li>
                                 <li><strong>Gift of your choice</strong> – If you wish to give your child the gift of your choice, please hand-over the gift to our Santa before they enter your house. Please note that the gift should not be more than the size of a shoe-box for it to fit in our Santa Sack. </li>
                                 <li><strong>Presence of an adult guardian</strong> - We have trained our performers under stringent guidelines and have their background checks to ensure a quality experience, however presence of a guardian/parent is mandatory throughout the delivery of our service i.e. Visit by Santa. The company and/or any of its representatives shall not be responsible for loss of any personal belongings of the beneficiaries and people associated with the beneficiaries.</li>
                                 <li><strong>Parking and Entry Procedures</strong> - The customers are requested to manage entry and parking procedures well before the arrival of our performers to save the time and allow for a quality service. Any delay caused due to any such issues shall proportionately attract the reduction in the time of the visit. </li>
                                 <li>The company shall not be liable in any manner whatsoever for quality of goods including gifts, merchandise, party supplies and food products supplied or services provided by third parties.</li>
                                 <li>All bookings are non transferable</li>
                                 <li>The company reserves the right to cancel any booking without prior notification.</li>
                              </ol>
                              <p><strong>Cancellation and Amendment</strong></p>
                              <ul style="font-weight:normal; text-align:justify; ">
                                 <li>Once the booking is done it cannot be cancelled and the amount that is once paid is non-refundable, 100% cancellation charges shall apply.</li>
                                 <li>
                                    <strong>Amendment</strong>: A customer is allowed to make an amendment only once and 7 days prior to the scheduled delivery of service. There shall be only one Amendment window and all the necessary amendments have to be done together only, all at once. 
                                    <ol>
                                       <li>
                                          The amendment shall be restricted to
                                          <ul>
                                             <li><strong>Change in the date and time</strong> – Customer can change the date and time of the delivery of the service/offering by paying the difference amount. Note that if the amount already paid for previous date and time of the booking is more than the new booking on different date and time, that the difference amount if found lesser in value than the previous date & time of the booking, that difference shall not be refunded.</li>
                                             <li>Increase in the number of beneficiaries – A customer can increase the number of beneficiaries and pay the difference amount. Though a customer cannot decrease the number of beneficiaries. </li>
                                             <li><strong>Change in address</strong> – Change in address shall be limited by the area and city. I.e. a customer can choose a different address of delivery but in the same area, and in the same city.</li>
                                             <li><strong>Contact and Other details</strong> – Contact and other details can be updated only once.</li>
                                          </ul>
                                       </li>
                                    </ol>
                                 </li>
                              </ul>
                              <p><strong>Terms & Conditions</strong></p>
                              <ul style="font-weight:normal; text-align:justify;">
                                 <li>Review our <strong><a href="#">General Terms and Conditions</a></strong> and <strong><a href="#">Privacy Policy</a></strong></li>
                              </ul>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </td>
            </tr>
             <tr>
               <td style="padding:20px 40px ;">&nbsp;</td>
            </tr>
            <tr>
               <td style="padding:0 40px ;">&nbsp;</td>
            </tr>
            <tr>
               <td style="padding:0 40px; font-weight:bold; font-size:14px; font-family:'arial', sans-serif;">
                  <p><strong>Our Partners</strong></p>
               </td>
            </tr>
            <tr>
               <td style="padding:0px 40px;"><img  style="display: block; width:640px;" src="http://www.wantasanta.com/mailers/confirmation-mailer/logos.jpg"/></td>
            </tr>
            <tr>
               <td>&nbsp;</td>
            </tr>
            <tr>
               <td>&nbsp;</td>
            </tr>
            <tr>
               <td><img width="100%" style="display: block; width:794px;" src="http://www.wantasanta.com/mailers/confirmation-mailer/confirmation-pdf-footer.jpg"></td>
            </tr>
         </tbody>
      </table>
   </body>
</html>