// //Append for location
// $(document).ready(function() {
//     $('#add_location').click(function() {
//         result = '';
//         count = $(this).data('count') + 1;
//         console.log(count);
//         $(this).data('count', count);

//         result = `
//                 <div class="card location_group" id="location-${count}">
//                     <div class="card-body border">
//                         <div class="form-group">
//                             <label>Location-${count}</label>
//                             <div class="input-group mb-3">
//                                 <input type="text" name="location[${count}][title]" class="form-control" placeholder="Enter location title" required>
//                                 <input type="text" name="location[${count}][address]" class="form-control" placeholder="Enter location address" required>
//                                 <div class="div contact_div">
//                                 <span class="input-group-text text-danger" onclick="delete_section_1(${count})"><i class="tim-icons icon-trash-simple"></i></span>
//                                 </div>
//                             </div>
//                         </div>
//                         <div class="form-group">
//                             <label>Location URL -${count}</label>
//                             <input type="text" name="location[${count}][url]" class="form-control" placeholder="Enter location url" required>
//                         </div>
//                     </div>
//                 </div>


//                 `;

//         $('#location').append(result);
//     });
// });
// function delete_section_1(count) {
//     $('#location-' + count).remove();
// };


// //Append for social
// $(document).ready(function() {
//     $('#add_social').click(function() {
//         result = '';
//         count = $(this).data('count') + 1;
//         $(this).data('count', count);

//         result = `<div class="form-group" id='social-${count}'>
//                     <label>Social Media Information-${count}</label>
//                     <div class="input-group mb-3">
//                         <input type="url" name="social[${count}][link]" class="form-control" placeholder="Enter socilal media information"  required>
//                         <div class="div">
//                             <select class="input-group-text form-select" name="social[${count}][icon]">
//                                 <option value="fa-brands fa-facebook-f" title="Facebook"><i>&#xf09a</i></option>
//                                 <option value="fa-brands fa-square-x-twitter" title="Twitter"><i>&#xe61a</i></option>
//                                 <option value="fa-brands fa-linkedin-in" title="Linkedin"><i>&#xf0e1</i></option>
//                                 <option value="fa-brands fa-instagram" title="Instagram"><i>&#xf16d</i></option>
//                                 <option value="fa-brands fa-youtube" title="Youtube"><i>&#xf167</i></option>
//                                 <option value="fa-brands fa-pinterest" title="Pinterest"><i>&#xf0d2</i></option>
//                                 <option value="fa-brands fa-google" title="Google"><i>&#xf1a0</i></option>
//                                 <option value="fa-brands fa-tiktok" title="Tiktok"><i>&#xe07b</i></option>
//                                 <option value="fa-brands fa-telegram" title="Telegram"><i>&#xf2c6</i></option>
//                                 <option value="fa-brands fa-whatsapp" title="WhatsApp"><i>&#xf232</i></option>
//                                 <option value="fa-brands fa-reddit" title="Reddit"><i>&#xf1a1</i></option>
//                             </select>
//                             <span class="input-group-text text-danger" onclick="delete_section_2(${count})"><i class="tim-icons icon-trash-simple"></i></span>
//                         </div>
//                     </div>
//                 </div>`;

//         $('#social').append(result);
//     });
// });
// function delete_section_2(count) {
//     $('#social-' + count).remove();
// };


// $(document).ready(function() {
//     $('#add_phone').click(function() {
//         result = '';
//         count = $(this).data('count') + 1;
//         $(this).data('count', count);

//         result = `<div class="form-group" id="phone-${count}">
//                     <label>Phone Number-${count}</label>
//                     <div class="input-group mb-3">
//                         <input type="tel" name="phone[${count}][number]" class="form-control" placeholder="Enter phone number" required>
//                         <div class="div contact_div">
//                             <select class="input-group-text form-select" name="phone[${count}][type]">
//                                 <option value="Phone" title='Phone'>Phone</option>
//                                 <option value="Telephone" title='Telephone'>Telephone</option>
//                                 <option value="Fax" title='Fax'>Fax</option>
//                                 <option value="WhatsApp" title='WhatsApp'>WhatsApp</option>
//                             </select>
//                             <span class="input-group-text text-danger" onclick="delete_section_3(${count})"><i class="tim-icons icon-trash-simple"></i></span>
//                         </div>
//                     </div>
//                 </div>`;
//         $('#phone').append(result);
//     });
// });
// function delete_section_3(count) {
//     $('#phone-' + count).remove();
// };


// //Append for Email
// $(document).ready(function() {
//     $('#add_email').click(function() {
//         result = '';
//         count = $(this).data('count') + 1;
//         $(this).data('count', count);

//         result = `<div class="form-group" id="email-${count}">
//                     <label>Email-${count}</label>
//                     <div class="input-group mb-3">
//                         <input type="text" name="email[]" class="form-control" placeholder="Enter Phone"  required>
//                         <span class="input-group-text text-danger" onclick="delete_section_4(${count})"><i class="tim-icons icon-trash-simple"></i></span>
//                     </div>
//                 </div>`;

//         $('#email').append(result);

//     });
// });
// function delete_section_4(count) {
//     $('#email-' + count).remove();
// };

// Tab JS
function openTab(evt, tabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" btn-success text-white", "");
    }
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " btn-success text-white";
  }
  document.getElementById("defaultOpen").click();
