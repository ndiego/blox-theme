<?php
/**
 * Email Footer
 *
 * @author 		Easy Digital Downloads
 * @package 	Easy Digital Downloads/Templates/Emails
 * @version     2.1
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


// For gmail compatibility, including CSS styles in head/body are stripped out therefore styles need to be inline. These variables contain rules which are added to the template inline.
$template_footer = "
	background-color: #2e2f33;
	border-top:0;
	border-radius:0;
	-webkit-border-radius:0px;
";

$credit = "
	border:0;
	color: #959595;
	font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif;
	font-size:12px;
	line-height:125%;
	text-align:center;
	padding: 20px 0;
";
?>
															</div>
														</td>
                                                    </tr>
                                                </table>
                                                <!-- End Content -->
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- End Body -->
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top">
                                    <!-- Footer -->
                                    <table border="0" cellpadding="10" cellspacing="0" width="600" id="template_footer" style="<?php echo $template_footer; ?>">
                                        <tr>
                                            <td valign="top">
                                                <table border="0" cellpadding="10" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td colspan="2" valign="middle" id="credit" style="<?php echo $credit; ?>">
                                                        	<a href="https://www.bloxwp.com" style="color:#959595;text-decoration:none">Blox</a> is a product of Outermost Design, LLC &nbsp;&middot;&nbsp;  <a href="mailto:support@bloxwp.com" style="color:#959595;text-decoration:none">support@bloxwp.com</a> &nbsp;&middot;&nbsp; <a href="https://www.bloxwp.com/terms-conditions" style="color:#959595;text-decoration:none">Terms &amp; Conditions</a>
                                                           <?php // echo wpautop( wp_kses_post( wptexturize( apply_filters( 'edd_email_footer_text', '<a href="' . esc_url( home_url() ) . '">' . get_bloginfo( 'name' ) . '</a>' ) ) ) ); ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- End Footer -->
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>
