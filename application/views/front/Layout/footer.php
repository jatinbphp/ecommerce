<footer class="light-footer">
    <div class="footer-middle">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                    <div class="footer_widget">
                        <img src="<?php echo base_url('images/logo.png')?>" class="img-footer small mb-2" alt="" />
                        <div class="address mt-3">
                        <a href="javaScript:;"><?php echo isset($footer_data['settingsData']['address']) ? $footer_data['settingsData']['address'] : ''; ?></a>
                        </div>
                        <div class="address mt-3">
                            <a href="tel:<?php echo isset($footer_data['settingsData']['phone_number']) ? $footer_data['settingsData']['phone_number'] : ''; ?>"><?php echo isset($footer_data['settingsData']['phone_number']) ? $footer_data['settingsData']['phone_number'] : ''; ?></a>
                            <br>
                            <a href="mailto:<?php echo isset($footer_data['settingsData']['email_address']) ? $footer_data['settingsData']['email_address'] : ''; ?>"><?php echo isset($footer_data['settingsData']['email_address']) ? $footer_data['settingsData']['email_address'] : ''; ?></a>
                        </div>
                        <div class="address mt-3">
                            <ul class="list-inline">
                                <li class="list-inline-item"><a href="<?php echo isset($footer_data['settingsData']['facebook_url']) ? $footer_data['settingsData']['facebook_url'] : 'javascript:(0);'; ?>" target="_blank"><i class="lni lni-facebook-filled"></i></a></li>
                                <li class="list-inline-item"><a href="<?php echo isset($footer_data['settingsData']['twitter_url']) ? $footer_data['settingsData']['twitter_url'] : 'javascript:(0);'; ?>" target="_blank"><i class="lni lni-twitter-filled"></i></a></li>
                                <li class="list-inline-item"><a href="<?php echo isset($footer_data['settingsData']['youtube_url']) ? $footer_data['settingsData']['youtube_url'] : 'javascript:(0);'; ?>" target="_blank"><i class="lni lni-youtube"></i></a></li>
                                <li class="list-inline-item"><a href="<?php echo isset($footer_data['settingsData']['instagram_url']) ? $footer_data['settingsData']['instagram_url'] : 'javascript:(0);'; ?>" target="_blank"><i class="lni lni-instagram-filled"></i></a></li>
                                <li class="list-inline-item"><a href="<?php echo isset($footer_data['settingsData']['linkedin_url']) ? $footer_data['settingsData']['linkedin_url'] : 'javascript:(0);'; ?>" target="_blank"><i class="lni lni-linkedin-original"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
                    <div class="footer_widget">
                        <h4 class="widget_title">Supports</h4>
                        <ul class="footer-menu">
                            <li><a href="<?php echo base_url('privecy-policy') ?>">Privacy Policy</a></li>
                            <li><a href="<?php echo base_url('terms-conditions') ?>">Terms & Conditions</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
                    <div class="footer_widget">
                        <h4 class="widget_title">Shop</h4>
                        <ul class="footer-menu">
                            <?php if (isset($footer_data['footerMenuCategoriesNames']) && is_array($footer_data['footerMenuCategoriesNames'])): ?>
                                <?php foreach ($footer_data['footerMenuCategoriesNames'] as $key => $categoryName): ?>
                                    <li><a href="<?php echo base_url("shop/categories/$key") ?>" data-categoryId="<?php echo $key ?>"><?php echo $categoryName; ?></a></li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
                    <div class="footer_widget">
                        <h4 class="widget_title">Company</h4>
                        <ul class="footer-menu">
                            <li><a href="<?php echo base_url() ?>">Home</a></li>
                            <li><a href="<?php echo base_url('about-us') ?>">About Us</a></li>
                            <li><a href="<?php echo base_url('contact') ?>">Contact Us</a></li>
                            <?php if ($this->session->userdata('logged_in')): ?>
                                <li><a href="<?php echo base_url('logout'); ?>">Log Out</a></li>
                            <?php else: ?>
                                <li><a href="<?php echo base_url('signIn') ?>">Login</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                    <div class="footer_widget">
                        <h4 class="widget_title">Subscribe</h4>
                        <p>Receive updates, Promotions, news, sent straignt in your inbox daily</p>
                        <div class="foot-news-last">
                            <div class="input-group">
                                <input type="text" id='subscribeEmailId' class="form-control" placeholder="Email Address">
                                <div class="input-group-append">
                                    <button type="button" onClick='openSubscription()' class="input-group-text bg-dark b-0 text-light"><i class="lni lni-arrow-right"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="address mt-3">
                            <h5 class="fs-sm">Secure Payments</h5>
                            <div class='row'>
                                <div class='col-12 col-lg-12 col-xl-12'>
                                    <svg width="50" viewBox="0 0 780 500" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_6278_125851)">
                                            <path d="M40 0H740C762.092 0 780 17.909 780 40V460C780 482.092 762.092 500 740 500H40C17.909 500 0 482.092 0 460V40C0 17.909 17.909 0 40 0Z" fill="#1434CB"/>
                                            <path d="M489.823 143.111C442.988 143.111 401.134 167.393 401.134 212.256C401.134 263.706 475.364 267.259 475.364 293.106C475.364 303.989 462.895 313.731 441.6 313.731C411.377 313.731 388.789 300.119 388.789 300.119L379.123 345.391C379.123 345.391 405.145 356.889 439.692 356.889C490.898 356.889 531.19 331.415 531.19 285.784C531.19 231.419 456.652 227.971 456.652 203.981C456.652 195.455 466.887 186.114 488.122 186.114C512.081 186.114 531.628 196.014 531.628 196.014L541.087 152.289C541.087 152.289 519.818 143.111 489.823 143.111ZM61.3294 146.411L60.1953 153.011C60.1953 153.011 79.8988 156.618 97.645 163.814C120.495 172.064 122.122 176.868 125.971 191.786L167.905 353.486H224.118L310.719 146.411H254.635L198.989 287.202L176.282 167.861C174.199 154.203 163.651 146.411 150.74 146.411H61.3294ZM333.271 146.411L289.275 353.486H342.756L386.598 146.411H333.271ZM631.554 146.411C618.658 146.411 611.825 153.318 606.811 165.386L528.458 353.486H584.542L595.393 322.136H663.72L670.318 353.486H719.805L676.633 146.411H631.554ZM638.848 202.356L655.473 280.061H610.935L638.848 202.356Z" fill="white"/>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_6278_125851">
                                                <rect width="780" height="500" fill="white"/>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    <svg width="50" enable-background="new 0 0 780 500" version="1.1" viewBox="0 0 780 500" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="M40,0h700c22.092,0,40,17.909,40,40v420c0,22.092-17.908,40-40,40H40c-22.091,0-40-17.908-40-40V40   C0,17.909,17.909,0,40,0z" fill="#0079BE"/><path d="m599.93 251.45c0-99.415-82.98-168.13-173.9-168.1h-78.242c-92.003-0.033-167.73 68.705-167.73 168.1 0 90.93 75.727 165.64 167.73 165.2h78.242c90.914 0.436 173.9-74.294 173.9-165.2z" fill="#fff"/><path d="m348.28 97.43c-84.07 0.027-152.19 68.308-152.21 152.58 0.02 84.258 68.144 152.53 152.21 152.56 84.09-0.027 152.23-68.303 152.24-152.56-0.011-84.272-68.149-152.55-152.24-152.58z" fill="#0079BE"/><path d="m252.07 249.6c0.08-41.181 25.746-76.297 61.94-90.25v180.48c-36.194-13.948-61.861-49.045-61.94-90.23zm131 90.274v-180.53c36.207 13.92 61.914 49.057 61.979 90.257-0.065 41.212-25.772 76.322-61.979 90.269z" fill="#fff"/></svg>
                                    <svg width="50" viewBox="0 0 780 500" xmlns="http://www.w3.org/2000/svg"><g fill-rule="evenodd"><path d="M54.992 0C24.627 0 0 24.63 0 55.004v390.992C0 476.376 24.619 501 54.992 501h670.016C755.373 501 780 476.37 780 445.996V55.004C780 24.624 755.381 0 725.008 0H54.992z" fill="#4D4D4D"/><path d="M327.152 161.893c8.837 0 16.248 1.784 25.268 6.09v22.751c-8.544-7.863-15.955-11.154-25.756-11.154-19.264 0-34.414 15.015-34.414 34.05 0 20.075 14.681 34.196 35.37 34.196 9.312 0 16.586-3.12 24.8-10.857v22.763c-9.341 4.14-16.911 5.776-25.756 5.776-31.278 0-55.582-22.596-55.582-51.737 0-28.826 24.951-51.878 56.07-51.878zm-97.113.627c11.546 0 22.11 3.72 30.943 10.994l-10.748 13.248c-5.35-5.646-10.41-8.028-16.564-8.028-8.853 0-15.3 4.745-15.3 10.989 0 5.354 3.619 8.188 15.944 12.482 23.365 8.044 30.29 15.176 30.29 30.926 0 19.193-14.976 32.553-36.32 32.553-15.63 0-26.994-5.795-36.458-18.872l13.268-12.03c4.73 8.61 12.622 13.222 22.42 13.222 9.163 0 15.947-5.952 15.947-13.984 0-4.164-2.055-7.734-6.158-10.258-2.066-1.195-6.158-2.977-14.2-5.647-19.291-6.538-25.91-13.527-25.91-27.185 0-16.225 14.214-28.41 32.846-28.41zm234.723 1.728h22.437l28.084 66.592 28.446-66.592h22.267l-45.494 101.686h-11.053l-44.687-101.686zm-397.348.152h30.15c33.312 0 56.534 20.382 56.534 49.641 0 14.59-7.104 28.696-19.118 38.057-10.108 7.901-21.626 11.445-37.574 11.445H67.414V164.4zm96.135 0h20.54v99.143h-20.54V164.4zm411.734 0h58.252v16.8H595.81v22.005h36.336v16.791h-36.336v26.762h37.726v16.785h-58.252V164.4zm71.858 0h30.455c23.69 0 37.265 10.71 37.265 29.272 0 15.18-8.514 25.14-23.986 28.105l33.148 41.766h-25.26l-28.429-39.828h-2.678v39.828h-20.515V164.4zm20.515 15.616v30.025h6.002c13.117 0 20.069-5.362 20.069-15.328 0-9.648-6.954-14.697-19.745-14.697h-6.326zM87.94 181.199v65.559h5.512c13.273 0 21.656-2.394 28.11-7.88 7.103-5.955 11.376-15.465 11.376-24.98 0-9.499-4.273-18.725-11.376-24.681-6.785-5.78-14.837-8.018-28.11-8.018H87.94z" fill="#FFF"/><path d="m415.13 161.21c30.941 0 56.022 23.58 56.022 52.709v0.033c0 29.13-25.081 52.742-56.021 52.742s-56.022-23.613-56.022-52.742v-0.033c0-29.13 25.082-52.71 56.022-52.71zm364.85 127.15c-26.05 18.33-221.08 149.34-558.75 212.62h503.76c30.365 0 54.992-24.63 54.992-55.004v-157.62z" fill="#F47216"/></g></svg>
                                    <svg width="50" enable-background="new 0 0 780 500" version="1.1" viewBox="0 0 780 500" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="m40 1e-3h700c22.092 0 40 17.909 40 40v420c0 22.092-17.908 40-40 40h-700c-22.091 0-40-17.908-40-40v-420c0-22.091 17.909-40 40-40z" fill="#2557D6"/><path d="m0.253 235.69h37.441l8.442-19.51h18.9l8.42 19.51h73.668v-14.915l6.576 14.98h38.243l6.576-15.202v15.138h183.08l-0.085-32.026h3.542c2.479 0.083 3.204 0.302 3.204 4.226v27.8h94.689v-7.455c7.639 3.92 19.518 7.455 35.148 7.455h39.836l8.525-19.51h18.9l8.337 19.51h76.765v-18.532l11.626 18.532h61.515v-122.51h-60.88v14.468l-8.522-14.468h-62.471v14.468l-7.828-14.468h-84.38c-14.123 0-26.539 1.889-36.569 7.153v-7.153h-58.229v7.153c-6.383-5.426-15.079-7.153-24.75-7.153h-212.74l-14.274 31.641-14.659-31.641h-67.005v14.468l-7.362-14.468h-57.145l-26.539 58.246v64.261h3e-3zm236.34-17.67h-22.464l-0.083-68.794-31.775 68.793h-19.24l-31.858-68.854v68.854h-44.57l-8.42-19.592h-45.627l-8.505 19.592h-23.801l39.241-87.837h32.559l37.269 83.164v-83.164h35.766l28.678 59.587 26.344-59.587h36.485l1e-3 87.838zm-165.9-37.823l-14.998-35.017-14.915 35.017h29.913zm255.3 37.821h-73.203v-87.837h73.203v18.291h-51.289v15.833h50.06v18.005h-50.061v17.542h51.289l1e-3 18.166zm103.16-64.18c0 14.004-9.755 21.24-15.439 23.412 4.794 1.748 8.891 4.838 10.84 7.397 3.094 4.369 3.628 8.271 3.628 16.116v17.255h-22.104l-0.083-11.077c0-5.285 0.528-12.886-3.458-17.112-3.202-3.09-8.083-3.76-15.973-3.76h-23.523v31.95h-21.914v-87.838h50.401c11.199 0 19.451 0.283 26.535 4.207 6.933 3.924 11.09 9.652 11.09 19.45zm-27.699 13.042c-3.013 1.752-6.573 1.81-10.841 1.81h-26.62v-19.51h26.982c3.818 0 7.804 0.164 10.393 1.584 2.842 1.28 4.601 4.003 4.601 7.765 0 3.84-1.674 6.929-4.515 8.351zm62.844 51.138h-22.358v-87.837h22.358v87.837zm259.56 0h-31.053l-41.535-65.927v65.927h-44.628l-8.527-19.592h-45.521l-8.271 19.592h-25.648c-10.649 0-24.138-2.257-31.773-9.715-7.701-7.458-11.708-17.56-11.708-33.533 0-13.027 2.395-24.936 11.812-34.347 7.085-7.01 18.18-10.242 33.28-10.242h21.215v18.821h-20.771c-7.997 0-12.514 1.14-16.862 5.203-3.735 3.699-6.298 10.69-6.298 19.897 0 9.41 1.951 16.196 6.023 20.628 3.373 3.476 9.506 4.53 15.272 4.53h9.842l30.884-69.076h32.835l37.102 83.081v-83.08h33.366l38.519 61.174v-61.174h22.445v87.833zm-133.2-37.82l-15.165-35.017-15.081 35.017h30.246zm189.04 178.08c-5.322 7.457-15.694 11.238-29.736 11.238h-42.319v-18.84h42.147c4.181 0 7.106-0.527 8.868-2.175 1.665-1.474 2.605-3.554 2.591-5.729 0-2.561-1.064-4.593-2.677-5.811-1.59-1.342-3.904-1.95-7.722-1.95-20.574-0.67-46.244 0.608-46.244-27.194 0-12.742 8.443-26.156 31.439-26.156h43.649v-17.479h-40.557c-12.237 0-21.129 2.81-27.425 7.174v-7.175h-59.985c-9.595 0-20.854 2.279-26.179 7.175v-7.175h-107.12v7.175c-8.524-5.892-22.908-7.175-29.549-7.175h-70.656v7.175c-6.745-6.258-21.742-7.175-30.886-7.175h-79.077l-18.094 18.764-16.949-18.764h-118.13v122.59h115.9l18.646-19.062 17.565 19.062 71.442 0.061v-28.838h7.021c9.479 0.14 20.66-0.228 30.523-4.312v33.085h58.928v-31.952h2.842c3.628 0 3.985 0.144 3.985 3.615v28.333h179.01c11.364 0 23.244-2.786 29.824-7.845v7.845h56.78c11.815 0 23.354-1.587 32.134-5.649l2e-3 -22.84zm-354.94-47.155c0 24.406-19.005 29.445-38.159 29.445h-27.343v29.469h-42.591l-26.984-29.086-28.042 29.086h-86.802v-87.859h88.135l26.961 28.799 27.875-28.799h70.021c17.389 0 36.929 4.613 36.929 28.945zm-174.22 40.434h-53.878v-17.48h48.11v-17.926h-48.11v-15.974h54.939l23.969 25.604-25.03 25.776zm86.81 10.06l-33.644-35.789 33.644-34.65v70.439zm49.757-39.066h-28.318v-22.374h28.572c7.912 0 13.404 3.09 13.404 10.772 0 7.599-5.238 11.602-13.658 11.602zm148.36-40.373h73.138v18.17h-51.315v15.973h50.062v17.926h-50.062v17.48l51.314 0.08v18.23h-73.139l2e-3 -87.859zm-28.119 47.029c4.878 1.725 8.865 4.816 10.734 7.375 3.095 4.291 3.542 8.294 3.631 16.037v17.418h-22.002v-10.992c0-5.286 0.531-13.112-3.542-17.198-3.201-3.147-8.083-3.899-16.076-3.899h-23.42v32.09h-22.02v-87.859h50.594c11.093 0 19.173 0.47 26.366 4.146 6.915 4.004 11.266 9.487 11.266 19.511-1e-3 14.022-9.764 21.178-15.531 23.371zm-12.385-11.107c-2.932 1.667-6.556 1.811-10.818 1.811h-26.622v-19.732h26.982c3.902 0 7.807 0.08 10.458 1.587 2.84 1.423 4.538 4.146 4.538 7.903 0 3.758-1.699 6.786-4.538 8.431zm197.82 5.597c4.27 4.229 6.554 9.571 6.554 18.613 0 18.9-12.322 27.723-34.425 27.723h-42.68v-18.84h42.51c4.157 0 7.104-0.525 8.95-2.175 1.508-1.358 2.589-3.333 2.589-5.729 0-2.561-1.17-4.592-2.675-5.811-1.675-1.34-3.986-1.949-7.803-1.949-20.493-0.67-46.157 0.609-46.157-27.192 0-12.744 8.355-26.158 31.33-26.158h43.932v18.7h-40.198c-3.984 0-6.575 0.145-8.779 1.587-2.4 1.422-3.29 3.534-3.29 6.319 0 3.314 2.037 5.57 4.795 6.546 2.311 0.77 4.795 0.995 8.526 0.995l11.797 0.306c11.895 0.276 20.061 2.248 25.024 7.065zm86.955-23.52h-39.938c-3.986 0-6.638 0.144-8.867 1.587-2.312 1.423-3.202 3.534-3.202 6.322 0 3.314 1.951 5.568 4.791 6.544 2.312 0.771 4.795 0.996 8.444 0.996l11.878 0.304c11.983 0.284 19.982 2.258 24.86 7.072 0.891 0.67 1.422 1.422 2.033 2.175v-25h1e-3z" fill="#fff"/></svg>
                                    <svg width="50" enable-background="new 0 0 780 500" version="1.1" viewBox="0 0 780 500" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="M41.68,0h698.14c23.027,0,41.68,18.983,41.68,42.42v414.66c0,23.437-18.652,42.42-41.68,42.42H41.68    C18.652,499.5,0,480.517,0,457.08V42.42C0,18.983,18.652,0,41.68,0z"/><path d="m167.25 181.4c6.8-2.3 14.1-3.5 21.7-3.5 33.2 0 60.9 23.601 67.2 54.9l47-9.6c-10.8-53.2-57.8-93.301-114.2-93.301-12.9 0-25.3 2.101-36.9 6l15.2 45.501z" fill="#FFF100"/><path d="m111.75 333.8l31.8-36c-14.2-12.6-23.1-30.9-23.1-51.4 0-20.399 8.9-38.8 23.1-51.3l-31.8-35.899c-24.1 21.399-39.3 52.5-39.3 87.3 0 34.699 15.2 65.898 39.3 87.299z" fill="#00A3DF"/><path d="m256.15 260.2c-6.4 31.3-34 54.8-67.2 54.8-7.6 0-14.9-1.2-21.8-3.5l-15.2 45.5c11.6 3.899 24.1 6 37 6 56.4 0 103.4-40 114.2-93.2l-47-9.6z" fill="#EE4023"/><path d="m459.75 292.4c-7.8 7.601-18.3 12.2-29.9 12-8-0.1-15.399-2.5-21.6-6.5l-15.601 24.801c10.7 6.699 23.2 10.699 36.801 10.899 19.699 0.3 37.699-7.5 50.8-20.2l-20.5-21zm-28.2-101.1c-39.2-0.6-71.6 30.8-72.2 70-0.2 14.7 4 28.5 11.5 39.9l128.8-55.101c-7.2-30.899-34.8-54.2-68.1-54.799m-42.7 75.599c-0.2-1.6-0.3-3.3-0.3-5 0.4-23.1 19.4-41.6 42.5-41.199 12.6 0.199 23.8 5.899 31.3 14.899l-73.5 31.3zm151.3-107.6v137.3l23.801 9.9-11.301 27.1-23.6-9.8c-5.3-2.3-8.9-5.8-11.6-9.8-2.601-4-4.601-9.601-4.601-17v-137.7h27.301zm85.901 63.5c4.2-1.4 8.6-2.1 13.3-2.1 20.3 0 37.101 14.399 41 33.5l28.7-5.9c-6.6-32.5-35.3-56.9-69.7-56.9-7.899 0-15.5 1.301-22.5 3.601l9.2 27.799zm-33.901 92.9l19.4-21.9c-8.7-7.7-14.1-18.9-14.1-31.4s5.5-23.699 14.1-31.3l-19.4-21.899c-14.699 13-24 32.1-24 53.3s9.301 40.199 24 53.199zm88.201-44.801c-3.899 19.101-20.8 33.5-41 33.5-4.6 0-9.1-0.8-13.3-2.199l-9.3 27.8c7.1 2.399 14.7 3.7 22.6 3.7 34.4 0 63.101-24.4 69.7-56.9l-28.7-5.901z" fill="#fff"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12 col-md-12 text-center">
                <p class="mb-0">© 2024 Ecommerce. Designd By <a href="javaScript:void(0)" target="_blank">Nxsol</a>.</p>
            </div>
        </div>
    </div>
   
</div>
</footer>

<script>
    function AjaxUploadImage(obj,id){
        var file = obj.files[0];
        var imagefile = file.type;
        var match = ["image/jpeg", "image/png", "image/jpg", 'image/webp'];
        if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]) || (imagefile == match[3])))
        {
            $('#previewing'+URL).attr('src', 'noimage.png');
            alert("<p id='error'>Please Select A valid Image File</p>" + "<h4>Note</h4>" + "<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
            return false;
        } else{
            var reader = new FileReader();
            reader.onload = imageIsLoaded;
            reader.readAsDataURL(obj.files[0]);
        }

        function imageIsLoaded(e){
            $('#DisplayImage').css("display", "block");
            $('#DisplayImage').css("margin-top", "1.5%");
            $('#DisplayImage').attr('src', e.target.result);
            $('#DisplayImage').attr('width', '150');
        }

    }

    function openSubscription(){
        var email = $('#subscribeEmailId').val();
        if(!email){
            SnackbarAlert('Please add email address.');
            return;
        }
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if(!emailRegex.test(email)){
            SnackbarAlert('Please enter valid email address.');
            return;
        }
        $.ajax({
            url: baseUrl+"subscription-plans",
            type: "post",
            data: {
                'email': email,
            },
            success: function(response) {
                $("#subscriptionbody").html(response);
                $("#subscription").modal('show');
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    function updatePlan(checkBox){
        var action = 'remove';
        var planId = $(checkBox).attr('id');
        var email = $(checkBox).attr('data-email');
        if(!planId || planId == 0 || !email){
            SnackbarAlert('Something went wrong.');
            return;
        }
        if($(checkBox).is(':checked')){
            action = 'add';
        }

        $.ajax({
            url: baseUrl+"subscription-plans/update",
            type: "post",
            data: {
                'action': action,
                'planId': planId,
                'email' : email,
            },
            success: function(response) {
                SnackbarAlert(response.message);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }
</script>
