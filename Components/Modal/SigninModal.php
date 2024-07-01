<div class="modal fade" id="SignIN" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content rounded-3">
            <div class="modal-header p-5 pb-4 border-bottom-0">
                <h1 class="fw-bold mb-0 fs-2">Welcome back!</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-5 pt-0">
                <div class="form-floating mb-3">
                    <input type="email" class="form-control rounded-3" id="MailAddress" placeholder="name@example.com">
                    <label for="MailAddress">Email address</label>
                </div>

                <div class="form-floating">
                    <input type="password" class="form-control rounded-3" id="Pword" placeholder="Password">
                    <label for="Pword">Password</label>
                </div>
                <div class="hstack gap-3 mb-3 mt-1">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="SPword">
                        <label class="form-check-label" for="SPword">
                            Show Password
                        </label>
                    </div>
                    <a href="#" class="link-body-emphasis link-offset-2 link-underline-opacity-25 link-underline-opacity-75-hover ms-auto">Forgot Password?</a>
                </div>
                <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit" id="btn-Sub">Sign in</button>
                <small class="text-body-secondary">By clicking Sign up, you agree to the
                    <a href="#" class="link-body-emphasis link-underline-opacity-25 link-underline-opacity-75-hover" data-bs-toggle="modal" data-bs-target="#terms" data-bs-dismiss="modal">Terms and Conditions</a>
                    of our services.</small>
                <hr class="my-4">
                <h3 class="fs-5 fw-bold mb-3">Don't have an account?</h3>
                <button class="w-100 py-2 btn btn-outline-secondary rounded-3" type="submit" onclick="window.location.href = '../../Components/Register/Signup.php'">
                    <svg class="bi" width="20" height="20">
                        <use xlink:href="#Register" />
                    </svg>
                    Create an account
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="terms" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-body">
                <h1 class="fw-bold mb-0 fs-2">Terms and Conditions</h1>
                <p class="text-body-secondary">Last updated: <?php echo date("Y-m-d"); ?></p>
                <p class="text-body-secondary">Please read these terms and conditions carefully before using Our Service.</p>
                <h3 class="fs-5 fw-bold">Interpretation and Definitions</h3>
                <h4 class="fs-5 fw-bold">Interpretation</h4>
                <p class="text-body-secondary">The words of which the initial letter is capitalized have meanings defined under the following conditions. The following definitions shall have the same meaning regardless of whether they appear in singular or in plural.</p>
                <h4 class="fs-5 fw-bold">Definitions</h4>
                <p class="text-body-secondary">For the purposes of these Terms and Conditions:</p>
                <ul>
                    <li class="text-body-secondary">Country refers to: <?php echo $_SERVER['HTTP_HOST']; ?></li>
                    <li class="text-body-secondary">Company (referred to as either "the Company", "We", "Us" or "Our" in this Agreement) refers to <?php echo $_SERVER['HTTP_HOST']; ?>.</li>
                    <li class="text-body-secondary">Service refers to the Website.</li>
                    <li class="text-body-secondary">Terms and Conditions (also referred as "Terms") mean these Terms and Conditions that form the entire agreement between You and the Company regarding the use of the Service.</li>
                    <li class="text-body-secondary">Website refers to <?php echo $_SERVER['HTTP_HOST']; ?>, accessible from <?php echo $_SERVER['HTTP_HOST']; ?></li>
                    <li class="text-body-secondary">You means the individual accessing or using the Service, or the company, or other legal entity on behalf of which such individual is accessing or using the Service, as applicable.</li>
                </ul>
                <h3 class="fs-5 fw-bold">Acknowledgment</h3>
                <p class="text-body-secondary">These are the Terms and Conditions governing the use of this Service and the agreement that operates between You and the Company. These Terms and Conditions set out the rights and obligations of all users regarding the use of the Service.</p>
                <p class="text-body-secondary">Your access to and use of the Service is conditioned on Your acceptance of and compliance with these Terms and Conditions. These Terms and Conditions apply to all visitors, users, and others who access or use the Service.</p>
                <p class="text-body-secondary">By accessing or using the Service You agree to be bound by these Terms and Conditions. If You disagree with any part of these Terms and Conditions then You may not access the Service.</p>
                <p class="text-body-secondary">Your access to and use of the Service is also conditioned on Your acceptance of and compliance with the Privacy Policy of the Company. Our Privacy Policy describes Our policies and procedures on the collection, use, and disclosure of Your personal information when You use the Application or the Website and tells You about Your privacy rights and how the law protects You. Please read Our Privacy Policy carefully before using Our Service.</p>
                <h3 class="fs-5 fw-bold">Links to Other Websites</h3>
                <p class="text-body-secondary">Our Service may contain links to third-party web sites or services that are not owned or controlled by the Company.</p>
                <p class="text-body-secondary">The Company has no control over and assumes no responsibility for, the content, privacy policies, or practices of any third-party web sites or services. You further acknowledge and agree that the Company shall not be responsible or liable, directly or indirectly, for any damage or loss caused or alleged to be caused by or in connection with the use of or reliance on any such content, goods, or services available on or through any such web sites or services.</p>
                <p class="text-body-secondary">We strongly advise You to read the terms and conditions and privacy policies of any third-party web sites or services that You visit.</p>
                <h3 class="fs-5 fw-bold">Termination</h3>
                <p class="text-body-secondary">We may terminate or suspend Your access immediately, without prior notice or liability, for any reason whatsoever, including without limitation if You breach these Terms and Conditions.</p>
                <p class="text-body-secondary">Upon termination, Your right to use the Service will cease immediately.</p>
                <h3 class="fs-5 fw-bold">Governing Law</h3>
                <p class="text-body-secondary">The laws of the Country, excluding its conflicts of law rules, shall govern this Terms and Your use of the Service. Your use of the Application may also be subject to other local, state, national, or international laws.</p>
                <h3 class="fs-5 fw-bold">Terms and Conditions</h3>
                <p class="text-body-secondary">Welcome to Playaz Luxury Streetwear, all products displayed on Playaz Luxury Streetwear are subject to availability. We strive to ensure that our inventory is current and accurate, but there may be instances where an item is out of stock or no longer available. In such cases, we reserve the right to withdraw any products from our site at any time and to remove or edit any materials or content. We will do our best to notify you if a product you have ordered is unavailable and to provide you with alternative options.</p>
                <p class="text-body-secondary">When you place an order with Playaz Luxury Streetwear, you will receive an acknowledgment e-mail confirming receipt of your order. This email will only be an acknowledgment and will not constitute acceptance of your order. A contract between us will not be formed until we send you confirmation by email that the goods you ordered have been dispatched to you. Only those goods listed in the confirmation email sent at the time of dispatch will be included in the contract formed.</p>
                <p class="text-body-secondary">Playaz Luxury Streetwear is not responsible for any delays or damages that occur during the shipping process. We partner with reliable shipping companies to ensure your order reaches you in a timely and safe manner, but unforeseen circumstances can sometimes lead to delays. If your order is delayed or damaged in transit, please contact us, and we will work with the shipping company to resolve the issue as quickly as possible.</p>
                <p class="text-body-secondary">Note: 5 maximum orders per customer only.</p>
                <p class="text-body-secondary">Keep it P,</p>
                <p class="text-body-secondary">Playaz Luxury Streetwear</p>
            </div>
            <div class="modal-footer border-0 mt-0">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#SignIN" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>