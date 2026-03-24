<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Removed redirect to allow fresh registration if session is stale
?>
<!DOCTYPE html>
<html lang="en">
<style>
    /* Safety fallback for preloader */
    @keyframes fadeOut { from { opacity: 1; visibility: visible; } to { opacity: 0; visibility: hidden; } }
    .hide-preloader { animation: fadeOut 0.5s forwards; }
</style>

<!-- Mirrored from argoncryptos.com/my-account/register/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 03 Dec 2024 03:41:18 GMT -->
<!-- Added by HTTrack -->
<!-- Mirrored from tenvaultmarkets.com/my-account/register/index.php by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 28 Feb 2026 09:55:50 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
   <!-- Meta tags  -->
   <meta charset="UTF-8" />
   <meta http-equiv="X-UA-Compatible" content="IE=edge" />
   <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />

   <title>Tenvault Markets | Global Stock Trading Platform</title>
   


   <!-- CSS Assets -->
   <!-- CSS Assets -->
   <link rel="stylesheet" href="../assets/css/app.css" />
   




  
  
  


  
  
  


  <link rel="icon" type="image/png" sizes="16x16" href="../../assets/images/logo.png">
  <link rel="icon" type="image/png" sizes="32x32" href="../../assets/images/logo.png">
  <link rel="apple-touch-icon" sizes="180x180" href="../../assets/images/logo.png">



<style>
/* Branding Excellence */
        .uc-logo img,
        .auth-logo img,
        .header-logo img {
            height: 80px !important;
            width: auto !important;
            object-fit: contain;
            display: block;
            image-rendering: -webkit-optimize-contrast;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
        }

        @media (max-width: 768px) {
            .uc-logo img,
            .auth-logo img,
            .header-logo img {
                height: 60px !important;
            }
        }

        /* Mobile Sidebar Frosted Glass Refinement */
        #uc-menu-panel .uc-offcanvas-bar {
            background: rgba(0, 0, 0, 0.7) !important;
            backdrop-filter: blur(10px) !important;
            -webkit-backdrop-filter: blur(10px) !important;
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            width: 320px;
        }
    </style>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>





<body x-data class="is-header-blur" x-bind="$store.global.documentBody">
    <!-- No Preloader -->

    <!-- Page Wrapper -->
    <div id="root" class="min-h-100vh flex grow" x-cloak>
      <main class="grid w-full grow grid-cols-1 place-items-center py-8 px-4">
        <div class="w-full max-w-2xl">
          <!-- Logo & Header -->
          <div class="text-center mb-8 auth-logo">
            <a href="../../index.html" class="inline-block transition-transform hover:scale-105">
              <img src="../../assets/images/logo.png" alt="Tenvault Market Logo">
            </a>
            <h1 class="mt-5 text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
              Create an Account
            </h1>
            <p class="text-slate-400 mt-2 text-sm">
              Join our premium crypto community today
            </p>
          </div>

          <!-- Auth Card -->
          <div class="auth-card p-6 sm:p-8">
            
            <form method="post" class="space-y-5">
              <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5">
                <!-- First Name -->
                <div class="space-y-2">
                  <label class="block text-sm font-semibold text-slate-600 dark:text-slate-300">First Name</label>
                  <div class="input-wrapper relative">
                    <input required name="firstName" class="auth-input" placeholder="John" type="text" />
                    <i class="fas fa-user auth-icon"></i>
                  </div>
                </div>

                <!-- Last Name -->
                <div class="space-y-2">
                  <label class="block text-sm font-semibold text-slate-600 dark:text-slate-300">Last Name</label>
                  <div class="input-wrapper relative">
                    <input required name="lastName" class="auth-input" placeholder="Doe" type="text" />
                    <i class="fas fa-user auth-icon"></i>
                  </div>
                </div>

                <!-- Username -->
                <div class="space-y-2">
                  <label class="block text-sm font-semibold text-slate-600 dark:text-slate-300">Username</label>
                  <div class="input-wrapper relative">
                    <input required name="username" class="auth-input" placeholder="johndoe77" type="text" />
                    <i class="fas fa-at auth-icon"></i>
                  </div>
                </div>

                <!-- Email -->
                <div class="space-y-2">
                  <label class="block text-sm font-semibold text-slate-600 dark:text-slate-300">Email Address</label>
                  <div class="input-wrapper relative">
                    <input required name="email" class="auth-input" placeholder="john@example.com" type="email" />
                    <i class="fas fa-envelope auth-icon"></i>
                  </div>
                </div>

                <!-- Phone -->
                <div class="space-y-2">
                  <label class="block text-sm font-semibold text-slate-600 dark:text-slate-300">Phone Number</label>
                  <div class="input-wrapper relative">
                    <input required name="phone" class="auth-input" placeholder="+1 (555) 000-0000" type="text" />
                    <i class="fas fa-phone auth-icon"></i>
                  </div>
                </div>

                <!-- Password -->
                <div class="space-y-2">
                  <label class="block text-sm font-semibold text-slate-600 dark:text-slate-300">Password</label>
                  <div class="input-wrapper relative">
                    <input required name="password" class="auth-input" placeholder="Create a strong password" type="password" />
                    <i class="fas fa-lock auth-icon"></i>
                  </div>
                </div>

                <!-- Country -->
                <div class="space-y-2">
                  <label class="block text-sm font-semibold text-slate-600 dark:text-slate-300">Country</label>
                  <div class="input-wrapper relative">
                      <select name="country" required class="auth-select">
                        <option value="" disabled selected>Select Country</option>
                        <option value="Afghanistan">Afghanistan</option>
                        <option value="Albania">Albania</option>
                    <option value="Algeria">Algeria</option>
                    <option value="American Samoa">American Samoa</option>
                    <option value="Andorra">Andorra</option>
                    <option value="Angola">Angola</option>
                    <option value="Anguilla">Anguilla</option>
                    <option value="Antarctica">Antarctica</option>
                    <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                    <option value="Argentina">Argentina</option>
                    <option value="Armenia">Armenia</option>
                    <option value="Aruba">Aruba</option>
                    <option value="Australia">Australia</option>
                    <option value="Austria">Austria</option>
                    <option value="Azerbaijan">Azerbaijan</option>
                    <option value="Bahamas">Bahamas</option>
                    <option value="Bahrain">Bahrain</option>
                    <option value="Bangladesh">Bangladesh</option>
                    <option value="Barbados">Barbados</option>
                    <option value="Belarus">Belarus</option>
                    <option value="Belgium">Belgium</option>
                    <option value="Belize">Belize</option>
                    <option value="Benin">Benin</option>
                    <option value="Bermuda">Bermuda</option>
                    <option value="Bhutan">Bhutan</option>
                    <option value="Bolivia">Bolivia</option>
                    <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                    <option value="Botswana">Botswana</option>
                    <option value="Bouvet Island">Bouvet Island</option>
                    <option value="Brazil">Brazil</option>
                    <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                    <option value="Brunei Darussalam">Brunei Darussalam</option>
                    <option value="Bulgaria">Bulgaria</option>
                    <option value="Burkina Faso">Burkina Faso</option>
                    <option value="Burundi">Burundi</option>
                    <option value="Cambodia">Cambodia</option>
                    <option value="Cameroon">Cameroon</option>
                    <option value="Canada">Canada</option>
                    <option value="Cape Verde">Cape Verde</option>
                    <option value="Cayman Islands">Cayman Islands</option>
                    <option value="Central African Republic">Central African Republic</option>
                    <option value="Chad">Chad</option>
                    <option value="Chile">Chile</option>
                    <option value="China">China</option>
                    <option value="Christmas Island">Christmas Island</option>
                    <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                    <option value="Colombia">Colombia</option>
                    <option value="Comoros">Comoros</option>
                    <option value="Congo">Congo</option>
                    <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option>
                    <option value="Cook Islands">Cook Islands</option>
                    <option value="Costa Rica">Costa Rica</option>
                    <option value="Cote D'ivoire">Cote D'ivoire</option>
                    <option value="Croatia">Croatia</option>
                    <option value="Cuba">Cuba</option>
                    <option value="Cyprus">Cyprus</option>
                    <option value="Czech Republic">Czech Republic</option>
                    <option value="Denmark">Denmark</option>
                    <option value="Djibouti">Djibouti</option>
                    <option value="Dominica">Dominica</option>
                    <option value="Dominican Republic">Dominican Republic</option>
                    <option value="Ecuador">Ecuador</option>
                    <option value="Egypt">Egypt</option>
                    <option value="El Salvador">El Salvador</option>
                    <option value="Equatorial Guinea">Equatorial Guinea</option>
                    <option value="Eritrea">Eritrea</option>
                    <option value="Estonia">Estonia</option>
                    <option value="Ethiopia">Ethiopia</option>
                    <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                    <option value="Faroe Islands">Faroe Islands</option>
                    <option value="Fiji">Fiji</option>
                    <option value="Finland">Finland</option>
                    <option value="France">France</option>
                    <option value="French Guiana">French Guiana</option>
                    <option value="French Polynesia">French Polynesia</option>
                    <option value="French Southern Territories">French Southern Territories</option>
                    <option value="Gabon">Gabon</option>
                    <option value="Gambia">Gambia</option>
                    <option value="Georgia">Georgia</option>
                    <option value="Germany">Germany</option>
                    <option value="Ghana">Ghana</option>
                    <option value="Gibraltar">Gibraltar</option>
                    <option value="Greece">Greece</option>
                    <option value="Greenland">Greenland</option>
                    <option value="Grenada">Grenada</option>
                    <option value="Guadeloupe">Guadeloupe</option>
                    <option value="Guam">Guam</option>
                    <option value="Guatemala">Guatemala</option>
                    <option value="Guinea">Guinea</option>
                    <option value="Guinea-bissau">Guinea-bissau</option>
                    <option value="Guyana">Guyana</option>
                    <option value="Haiti">Haiti</option>
                    <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
                    <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
                    <option value="Honduras">Honduras</option>
                    <option value="Hong Kong">Hong Kong</option>
                    <option value="Hungary">Hungary</option>
                    <option value="Iceland">Iceland</option>
                    <option value="India">India</option>
                    <option value="Indonesia">Indonesia</option>
                    <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
                    <option value="Iraq">Iraq</option>
                    <option value="Ireland">Ireland</option>
                    <option value="Israel">Israel</option>
                    <option value="Italy">Italy</option>
                    <option value="Jamaica">Jamaica</option>
                    <option value="Japan">Japan</option>
                    <option value="Jordan">Jordan</option>
                    <option value="Kazakhstan">Kazakhstan</option>
                    <option value="Kenya">Kenya</option>
                    <option value="Kiribati">Kiribati</option>
                    <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
                    <option value="Korea, Republic of">Korea, Republic of</option>
                    <option value="Kuwait">Kuwait</option>
                    <option value="Kyrgyzstan">Kyrgyzstan</option>
                    <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
                    <option value="Latvia">Latvia</option>
                    <option value="Lebanon">Lebanon</option>
                    <option value="Lesotho">Lesotho</option>
                    <option value="Liberia">Liberia</option>
                    <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                    <option value="Liechtenstein">Liechtenstein</option>
                    <option value="Lithuania">Lithuania</option>
                    <option value="Luxembourg">Luxembourg</option>
                    <option value="Macao">Macao</option>
                    <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option>
                    <option value="Madagascar">Madagascar</option>
                    <option value="Malawi">Malawi</option>
                    <option value="Malaysia">Malaysia</option>
                    <option value="Maldives">Maldives</option>
                    <option value="Mali">Mali</option>
                    <option value="Malta">Malta</option>
                    <option value="Marshall Islands">Marshall Islands</option>
                    <option value="Martinique">Martinique</option>
                    <option value="Mauritania">Mauritania</option>
                    <option value="Mauritius">Mauritius</option>
                    <option value="Mayotte">Mayotte</option>
                    <option value="Mexico">Mexico</option>
                    <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
                    <option value="Moldova, Republic of">Moldova, Republic of</option>
                    <option value="Monaco">Monaco</option>
                    <option value="Mongolia">Mongolia</option>
                    <option value="Montserrat">Montserrat</option>
                    <option value="Morocco">Morocco</option>
                    <option value="Mozambique">Mozambique</option>
                    <option value="Myanmar">Myanmar</option>
                    <option value="Namibia">Namibia</option>
                    <option value="Nauru">Nauru</option>
                    <option value="Nepal">Nepal</option>
                    <option value="Netherlands">Netherlands</option>
                    <option value="Netherlands Antilles">Netherlands Antilles</option>
                    <option value="New Caledonia">New Caledonia</option>
                    <option value="New Zealand">New Zealand</option>
                    <option value="Nicaragua">Nicaragua</option>
                    <option value="Niger">Niger</option>
                    <option value="Nigeria">Nigeria</option>
                    <option value="Niue">Niue</option>
                    <option value="Norfolk Island">Norfolk Island</option>
                    <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                    <option value="Norway">Norway</option>
                    <option value="Oman">Oman</option>
                    <option value="Pakistan">Pakistan</option>
                    <option value="Palau">Palau</option>
                    <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
                    <option value="Panama">Panama</option>
                    <option value="Papua New Guinea">Papua New Guinea</option>
                    <option value="Paraguay">Paraguay</option>
                    <option value="Peru">Peru</option>
                    <option value="Philippines">Philippines</option>
                    <option value="Pitcairn">Pitcairn</option>
                    <option value="Poland">Poland</option>
                    <option value="Portugal">Portugal</option>
                    <option value="Puerto Rico">Puerto Rico</option>
                    <option value="Qatar">Qatar</option>
                    <option value="Reunion">Reunion</option>
                    <option value="Romania">Romania</option>
                    <option value="Russian Federation">Russian Federation</option>
                    <option value="Rwanda">Rwanda</option>
                    <option value="Saint Helena">Saint Helena</option>
                    <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                    <option value="Saint Lucia">Saint Lucia</option>
                    <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                    <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
                    <option value="Samoa">Samoa</option>
                    <option value="San Marino">San Marino</option>
                    <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                    <option value="Saudi Arabia">Saudi Arabia</option>
                    <option value="Senegal">Senegal</option>
                    <option value="Serbia and Montenegro">Serbia and Montenegro</option>
                    <option value="Seychelles">Seychelles</option>
                    <option value="Sierra Leone">Sierra Leone</option>
                    <option value="Singapore">Singapore</option>
                    <option value="Slovakia">Slovakia</option>
                    <option value="Slovenia">Slovenia</option>
                    <option value="Solomon Islands">Solomon Islands</option>
                    <option value="Somalia">Somalia</option>
                    <option value="South Africa">South Africa</option>
                    <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>
                    <option value="Spain">Spain</option>
                    <option value="Sri Lanka">Sri Lanka</option>
                    <option value="Sudan">Sudan</option>
                    <option value="Suriname">Suriname</option>
                    <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                    <option value="Swaziland">Swaziland</option>
                    <option value="Sweden">Sweden</option>
                    <option value="Switzerland">Switzerland</option>
                    <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                    <option value="Taiwan, Province of China">Taiwan, Province of China</option>
                    <option value="Tajikistan">Tajikistan</option>
                    <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
                    <option value="Thailand">Thailand</option>
                    <option value="Timor-leste">Timor-leste</option>
                    <option value="Togo">Togo</option>
                    <option value="Tokelau">Tokelau</option>
                    <option value="Tonga">Tonga</option>
                    <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                    <option value="Tunisia">Tunisia</option>
                    <option value="Turkey">Turkey</option>
                    <option value="Turkmenistan">Turkmenistan</option>
                    <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                    <option value="Tuvalu">Tuvalu</option>
                    <option value="Uganda">Uganda</option>
                    <option value="Ukraine">Ukraine</option>
                    <option value="United Arab Emirates">United Arab Emirates</option>
                    <option value="United Kingdom">United Kingdom</option>
                    <option value="United States">United States</option>
                    <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                    <option value="Uruguay">Uruguay</option>
                    <option value="Uzbekistan">Uzbekistan</option>
                    <option value="Vanuatu">Vanuatu</option>
                    <option value="Venezuela">Venezuela</option>
                    <option value="Viet Nam">Viet Nam</option>
                    <option value="Virgin Islands, British">Virgin Islands, British</option>
                    <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
                    <option value="Wallis and Futuna">Wallis and Futuna</option>
                    <option value="Western Sahara">Western Sahara</option>
                    <option value="Yemen">Yemen</option>
                    <option value="Zambia">Zambia</option>
                    <option value="Zimbabwe">Zimbabwe</option>
                  </select>
                  <i class="fas fa-globe auth-icon"></i>
                  </div>
                </div>
                
                <!-- Currency -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-slate-600 dark:text-slate-300">Preferred Currency</label>
                    <div class="input-wrapper relative">
                        <select name="currency" required class="auth-select">
                            <option value="" disabled selected>Select Currency</option>
                            <option value="USD">USD - United States Dollar</option>
                            <option value="EUR">EUR - Euro</option>
                            <option value="GBP">GBP - British Pound Sterling</option>
                            <option value="JPY">JPY - Japanese Yen</option>
                            <option value="AUD">AUD - Australian Dollar</option>
                            <option value="CAD">CAD - Canadian Dollar</option>
                            <option value="CHF">CHF - Swiss Franc</option>
                            <option value="CNY">CNY - Chinese Yuan</option>
                            <option value="HKD">HKD - Hong Kong Dollar</option>
                            <option value="NZD">NZD - New Zealand Dollar</option>
                            <option value="SEK">SEK - Swedish Krona</option>
                            <option value="KRW">KRW - South Korean Won</option>
                            <option value="SGD">SGD - Singapore Dollar</option>
                            <option value="NOK">NOK - Norwegian Krone</option>
                            <option value="MXN">MXN - Mexican Peso</option>
                            <option value="INR">INR - Indian Rupee</option>
                            <option value="RUB">RUB - Russian Ruble</option>
                            <option value="ZAR">ZAR - South African Rand</option>
                            <option value="BRL">BRL - Brazilian Real</option>
                            <option value="AED">AED - UAE Dirham</option>
                            <option value="SAR">SAR - Saudi Riyal</option>
                            <option value="NGN">NGN - Nigerian Naira</option>
                            <option value="PLN">PLN - Polish Zloty</option>
                            <option value="TRY">TRY - Turkish Lira</option>
                            <option value="THB">THB - Thai Baht</option>
                            <option value="IDR">IDR - Indonesian Rupiah</option>
                            <option value="MYR">MYR - Malaysian Ringgit</option>
                            <option value="PHP">PHP - Philippine Peso</option>
                            <option value="CZK">CZK - Czech Koruna</option>
                            <option value="ILS">ILS - Israeli Shekel</option>
                            <option value="CLP">CLP - Chilean Peso</option>
                            <option value="PKR">PKR - Pakistani Rupee</option>
                            <option value="EGP">EGP - Egyptian Pound</option>
                            <option value="KWD">KWD - Kuwaiti Dinar</option>
                            <option value="QAR">QAR - Qatari Riyal</option>
                            <option value="BTC">BTC - Bitcoin</option>
                            <option value="ETH">ETH - Ethereum</option>
                            <option value="USDT">USDT - Tether</option>
                        </select>
                        <i class="fas fa-coins auth-icon"></i>
                    </div>
                </div>


              </div>

              <div class="space-y-2 pt-2">
                <label class="block text-sm font-semibold text-slate-600 dark:text-slate-300">Human Check</label>
                <div class="input-wrapper relative">
                  <input required name="captcha_answer" class="auth-input" placeholder="Answer" type="text" inputmode="numeric" autocomplete="off" />
                  <i class="fas fa-shield-alt auth-icon"></i>
                </div>
                <p class="text-xs text-slate-500 dark:text-slate-400">Solve: <strong>3 - 2 = ?</strong></p>
              </div>

              <!-- Terms Checkbox -->
              <div class="flex items-center gap-2 pt-2">
                <input required name="terms" id="terms" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-indigo-500 focus:ring-indigo-500" />
                <label for="terms" class="text-sm text-slate-500 dark:text-slate-400 cursor-pointer">
                  I agree with the <a href="../privacy-policy.html" class="font-bold text-indigo-500 hover:text-indigo-400 transition-colors">Privacy Policy</a>
                </label>
              </div>

              <!-- Submit Button -->
              <button type="submit" class="auth-btn w-full">
                Create My Account
              </button>

              <!-- Sign In Link -->
              <p class="text-center text-sm text-slate-500 dark:text-slate-400 pt-2">
                Already have an account? 
                <a href="../login/index.php" class="font-bold text-indigo-500 hover:text-indigo-400 transition-colors">Sign in instead</a>
              </p>
            </form>
          </div>

          <!-- Footer Links -->
          <div class="mt-6 flex items-center justify-center gap-4 text-xs text-slate-500">
            <a href="#" class="hover:text-indigo-400 transition-colors">Privacy Policy</a>
            <span class="text-slate-600">ÃƒÂ¢Ã¢â€šÂ¬Ã‚Â¢</span>
            <a href="#" class="hover:text-indigo-400 transition-colors">Terms of Service</a>
          </div>
        </div>
      </main>
    </div>

    <script>
      // Global Preloader Safety
      setTimeout(() => {
        const preloader = document.querySelector('.app-preloader');
        if (preloader) preloader.style.display = 'none';
      }, 3000);
    </script>
    <div id="x-teleport-target"></div>
    <script>
      document.querySelector('form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        
        // Merge names for the backend
        const fullName = `${formData.get('firstName')} ${formData.get('lastName')}`;
        formData.append('full_name', fullName);

        const btn = e.target.querySelector('button');
        const originalText = btn.innerText;
        btn.innerText = 'Creating Account...';
        btn.disabled = true;

        try {
          const response = await fetch('../../api/register_action.php', {
            method: 'POST',
            body: formData
          });
          const result = await response.json();
          alert(result.message);
          if (result.status === 'success') {
            window.location.href = '../login/index.php';
          } else {
            btn.innerText = originalText;
            btn.disabled = false;
          }
        } catch (error) {
          console.error('Error:', error);
          alert('An error occurred. Please try again.');
          btn.innerText = originalText;
          btn.disabled = false;
        }
      });

      window.addEventListener("DOMContentLoaded", () => Alpine.start());
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
   </body>

<!-- Mirrored from tenvaultmarkets.com/my-account/register/index.php by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 28 Feb 2026 09:55:51 GMT -->
</html>


