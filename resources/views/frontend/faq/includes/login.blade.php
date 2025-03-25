<div class="row g-3">
    <!-- Left Column - 5 Items -->
    <div class="col-12 col-lg-6">
        <div class="accordion" id="leftAccordion">
            <!-- Item 1 -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                            data-bs-target="#leftCollapse1" aria-expanded="true" aria-controls="leftCollapse1">
                        {{__('How do I log in or register?')}}
                    </button>
                </h2>
                <div id="leftCollapse1" class="accordion-collapse collapse show" 
                     data-bs-parent="#leftAccordion">
                    <div class="accordion-body">
                        {{ __('Our process is very simple. Enter your phone number on our single login/register page and tap the') }}
                        <a href="{{ route('login') }}">{{ __('Send OTP') }}</a> 
                        {{ __('button. If youre already registered, verifying the OTP logs you in; if not, a new account is created and youre logged in automatically.') }}
                    </div>
                </div>
            </div>
            
            <!-- Item 2 -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                            data-bs-target="#leftCollapse2" aria-expanded="false" aria-controls="leftCollapse2">
                        {{__('How do I receive the OTP?')}}
                    </button>
                </h2>
                <div id="leftCollapse2" class="accordion-collapse collapse" 
                     data-bs-parent="#leftAccordion">
                    <div class="accordion-body">
                        {{__('After entering your phone number, tap on “Send OTP.” The OTP will be sent directly to your mobile phone.')}}
                    </div>
                </div>
            </div>
            
            <!-- Item 3 -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                            data-bs-target="#leftCollapse3" aria-expanded="false" aria-controls="leftCollapse3">
                        {{__('What if I do not receive the OTP?')}}
                    </button>
                </h2>
                <div id="leftCollapse3" class="accordion-collapse collapse" 
                     data-bs-parent="#leftAccordion">
                    <div class="accordion-body">
                        {{__('Please check your network connection and ensure that your phone number is correct. You can also try resending the OTP.')}}
                    </div>
                </div>
            </div>
            
            <!-- Item 4 -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                            data-bs-target="#leftCollapse4" aria-expanded="false" aria-controls="leftCollapse4">
                        {{__('Can I log in using social media?')}}
                    </button>
                </h2>
                <div id="leftCollapse4" class="accordion-collapse collapse" 
                     data-bs-parent="#leftAccordion">
                    <div class="accordion-body">
                        {{__('Yes, we offer a social media login option via Google for added convenience.')}}
                    </div>
                </div>
            </div>
            
            <!-- Item 5 -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                            data-bs-target="#leftCollapse5" aria-expanded="false" aria-controls="leftCollapse5">
                        {{__('How do I reset my password if I forget it?')}}
                    </button>
                </h2>
                <div id="leftCollapse5" class="accordion-collapse collapse" 
                     data-bs-parent="#leftAccordion">
                    <div class="accordion-body">
                        {{__('Use the “Forgot Password” feature. Enter your phone number, receive an OTP, verify it, and then reset your password.')}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Right Column - 5 Items -->
    <div class="col-12 col-lg-6">
        <div class="accordion" id="rightAccordion">
            <!-- Item 6 -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                            data-bs-target="#rightCollapse1" aria-expanded="false" aria-controls="rightCollapse1">
                        {{__('How do I set up a password for future logins?')}}
                    </button>
                </h2>
                <div id="rightCollapse1" class="accordion-collapse collapse" 
                     data-bs-parent="#rightAccordion">
                    <div class="accordion-body">
                        {{__('Initially, log in using your phone number or social login. Then, update your profile with a new password which you can use for subsequent logins.')}}
                    </div>
                </div>
            </div>
            
            <!-- Item 7 -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                            data-bs-target="#rightCollapse2" aria-expanded="false" aria-controls="rightCollapse2">
                        {{__('Can I still use my phone number login after setting a password?')}}
                    </button>
                </h2>
                <div id="rightCollapse2" class="accordion-collapse collapse" 
                     data-bs-parent="#rightAccordion">
                    <div class="accordion-body">
                        {{__('Yes. You can log in either with your phone number (using OTP) or with your password once it is set.')}}
                    </div>
                </div>
            </div>
            
            <!-- Item 8 -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                            data-bs-target="#rightCollapse3" aria-expanded="false" aria-controls="rightCollapse3">
                        {{__('Is my personal information secure during the authentication process?')}}
                    </button>
                </h2>
                <div id="rightCollapse3" class="accordion-collapse collapse" 
                     data-bs-parent="#rightAccordion">
                    <div class="accordion-body">
                        {{__('Absolutely. Our system uses secure OTP verification and social login methods to protect your personal information.')}}
                    </div>
                </div>
            </div>
            
            <!-- Item 9 -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                            data-bs-target="#rightCollapse4" aria-expanded="false" aria-controls="rightCollapse4">
                        {{__('Can I use both phone number and social login methods?')}}
                    </button>
                </h2>
                <div id="rightCollapse4" class="accordion-collapse collapse" 
                     data-bs-parent="#rightAccordion">
                    <div class="accordion-body">
                        {{__('Yes, you can choose either method based on your preference. For password login, you must first log in via phone number or social media and then update your profile with a password.')}}
                    </div>
                </div>
            </div>
            
            <!-- Item 10 -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                            data-bs-target="#rightCollapse5" aria-expanded="false" aria-controls="rightCollapse5">
                        {{__('Who do I contact if I face any issues with login or OTP verification?')}}
                    </button>
                </h2>
                <div id="rightCollapse5" class="accordion-collapse collapse" 
                     data-bs-parent="#rightAccordion">
                    <div class="accordion-body">
                        {{__('If you experience any issues, please contact our customer support team, available 24/7, for immediate assistance.')}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>