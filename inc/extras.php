<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package bellaworks
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */

define('THEMEURI',get_template_directory_uri() . '/');

function bellaworks_body_classes( $classes ) {
    // Adds a class of group-blog to blogs with more than 1 published author.

    global $post;
    if ( isset( $post ) ) {
        $classes[] = $post->post_type . '-' . $post->post_name;
    }

    if ( is_multi_author() ) {
        $classes[] = 'group-blog';
    }

    // Adds a class of hfeed to non-singular pages.
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }

    if ( is_front_page() || is_home() ) {
        $classes[] = 'homepage';
    } else {
        $classes[] = 'subpage';
    }

    $browsers = ['is_iphone', 'is_chrome', 'is_safari', 'is_NS4', 'is_opera', 'is_macIE', 'is_winIE', 'is_gecko', 'is_lynx', 'is_IE', 'is_edge'];
    $classes[] = join(' ', array_filter($browsers, function ($browser) {
        return $GLOBALS[$browser];
    }));

    return $classes;
}
add_filter( 'body_class', 'bellaworks_body_classes' );

if( function_exists('acf_add_options_page') ) {
    acf_add_options_page();
}


function add_query_vars_filter( $vars ) {
  $vars[] = "pg";
  return $vars;
}
add_filter( 'query_vars', 'add_query_vars_filter' );


function shortenText($string, $limit, $break=".", $pad="...") {
  // return with no change if string is shorter than $limit
  if(strlen($string) <= $limit) return $string;

  // is $break present between $limit and the end of the string?
  if(false !== ($breakpoint = strpos($string, $break, $limit))) {
    if($breakpoint < strlen($string) - 1) {
      $string = substr($string, 0, $breakpoint) . $pad;
    }
  }

  return $string;
}

/* Fixed Gravity Form Conflict Js */
add_filter("gform_init_scripts_footer", "init_scripts");
function init_scripts() {
    return true;
}

function get_page_id_by_template($fileName) {
    $page_id = 0;
    if($fileName) {
        $pages = get_pages(array(
            'post_type' => 'page',
            'meta_key' => '_wp_page_template',
            'meta_value' => $fileName.'.php'
        ));

        if($pages) {
            $row = $pages[0];
            $page_id = $row->ID;
        }
    }
    return $page_id;
}

function string_cleaner($str) {
    if($str) {
        $str = str_replace(' ', '', $str); 
        $str = preg_replace('/\s+/', '', $str);
        $str = preg_replace('/[^A-Za-z0-9\-]/', '', $str);
        $str = strtolower($str);
        $str = trim($str);
        return $str;
    }
}

function format_phone_number($string) {
    if(empty($string)) return '';
    $append = '';
    if (strpos($string, '+') !== false) {
        $append = '+';
    }
    $string = preg_replace("/[^0-9]/", "", $string );
    $string = preg_replace('/\s+/', '', $string);
    return $append.$string;
}

function get_instagram_setup() {
    global $wpdb;
    $result = $wpdb->get_row( "SELECT option_value FROM $wpdb->options WHERE option_name = 'sb_instagram_settings'" );
    if($result) {
        $option = ($result->option_value) ? @unserialize($result->option_value) : false;
    } else {
        $option = '';
    }
    return $option;
}

function extract_emails_from($string){
  preg_match_all("/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i", $string, $matches);
  return $matches[0];
}

function email_obfuscator($string,$noFilter=null) {
    $output = '';
    $newString = '';
    if($string) {
        $emails_matched = ($string) ? extract_emails_from($string) : '';
        if($emails_matched) {
            foreach($emails_matched as $em) {
                $encrypted = antispambot($em,1);
                if (strpos($string, 'mailto') !== false) {
                    $replace = 'mailto:'.$em;
                    $new_mailto = 'mailto:'.$encrypted;
                    $string = str_replace($replace, $new_mailto, $string);
                    $rep2 = $em.'</a>';
                    $new2 = antispambot($em).'</a>';
                    $string = str_replace($rep2, $new2, $string);
                } else {
                    $new_mailto = '<a href="mailto:'.antispambot($em,1).'">'.antispambot($em).'</a>';
                    $newString = str_replace($em, $new_mailto, $string);
                }
            }

            if($noFilter) {
                $output = $newString;
            } else {
                $output = apply_filters('the_content',$string);
            }

        } else {
            $output = $string;
        }   
    }
    return $output;
}

function get_social_links() {
    $social_types = social_icons();
    $social = array();
    foreach($social_types as $k=>$icon) {
        $value = get_field($k,'option');
        if($value) {
            $social[$k] = array('link'=>$value,'icon'=>$icon);
        }
    }
    return $social;
}

function social_icons() {
    $social_types = array(
        'facebook'  => 'fab fa-facebook-f',
        'twitter'   => 'fab fa-twitter',
        'linkedin'  => 'fab fa-linkedin-in',
        'instagram' => 'fab fa-instagram',
        'snapchat'  => 'fab fa-snapchat-ghost',
        'youtube'   => 'fab fa-youtube'
    );
    return $social_types;
}

/* removing WP version generator */
function cma_remove_wp_version_string( $src )
{
    global $wp_version;

    parse_str( parse_url( $src, PHP_URL_QUERY), $query);
    if( ! empty( $query['ver'] ) && $query['ver'] === $wp_version ){
        $src = remove_query_arg( 'ver', $src );
    }
    return $src;
}
add_filter( 'script_loader_src', 'cma_remove_wp_version_string' );
add_filter( 'style_loader_src', 'cma_remove_wp_version_string' );

function cma_remove_meta_version(){
    return '';
}
add_filter( 'the_generator', 'cma_remove_meta_version' );


/* Display Vendor Information via Ajax */
add_action( 'wp_ajax_nopriv_vendor_details', 'vendor_details' );
add_action( 'wp_ajax_vendor_details', 'vendor_details' );
function vendor_details() {
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        $post_id = ($_POST['post_id']) ? $_POST['post_id'] : 0;
        $html = get_vendor_info_html($post_id);
        $response['title'] = ($post_id>0) ? get_the_title($post_id):'';
        $response['content'] = $html;
        echo json_encode($response);
    }
    else {
        header("Location: ".$_SERVER["HTTP_REFERER"]);
    }
    die();
}

function get_vendor_info_html($id) {
    $content = '';
    $post = get_post($id);
    if($post) {
        ob_start();  ?>
        <div class="vendor-detatils-wrap">
            <?php 
            $id = $post->ID;
            $logo = get_field("vendor_logo",$id); 
            $address = get_field("vendor_address",$id); 
            $phone = get_field("vendor_phone",$id); 
            $email = get_field("vendor_email",$id); 
            $website = get_field("vendor_website",$id); 
            $webdomain = '';
            if($website) {
                $web = parse_url($website);
                $host = $web['host'];
                $host = str_replace('www','',$host);
                $webdomain = 'www.'.$host;
            }
            ?>
            <div class="inner <?php echo ($logo) ? 'half':'full'; ?>">
                <?php if ($logo) { ?>
                <div class="logodiv">
                    <span><img src="<?php echo $logo['url'] ?>" alt="<?php echo $logo['title'] ?>" class="vendor-logo"></span>
                </div>
                <?php } ?>
                <div class="info">
                    <h2 class="name"><?php echo $post->post_title; ?></h2>
                    <?php if ($address) { ?>
                    <div class="data address"><span class="icon"><i class="fas fa-map-marker-alt"></i></span> <?php echo $address ?></div>
                    <?php } ?>
                    <?php if ($phone) { ?>
                    <div class="data phone"><span class="icon"><i class="fas fa-phone-alt"></i></span> <?php echo $phone ?></div>
                    <?php } ?>
                    <?php if ($email) { ?>
                    <div class="data email"><span class="icon"><i class="fas fa-envelope"></i></span> <a href="mailto:<?php echo antispambot($email,1) ?>"><?php echo antispambot($email) ?></a></div>
                    <?php } ?>
                    <?php if ($website) { ?>
                    <div class="data website"><span class="icon"><i class="fas fa-globe-americas"></i></span> <a href="<?php echo $website ?>" target="_blank"><?php echo $webdomain ?></a></div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php
        $content = ob_get_contents();
        ob_end_clean();
    }
    return $content;
}

/* Fixed issue on Options page when saving it goes to 404 page */
add_action( 'init', 'mycustomadminscripts' );
function mycustomadminscripts() {
   wp_register_script( "myadminscripts", get_stylesheet_directory_uri().'/assets/js/custom-admin.js', array('jquery') );
   wp_localize_script( 'myadminscripts', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));        
   wp_enqueue_script( 'jquery' );
   wp_enqueue_script( 'myadminscripts' );
}

add_action( 'admin_head', 'admin_head_action_func' );
function admin_head_action_func(){ ?>
<script type='text/javascript'>
    var wpAdminURL = '<?php echo get_admin_url(); ?>';
</script>
<style type="text/css">
div.acf-field-text.acf-field-5e7f01711e379,
body.toplevel_page_acf-options input#acf-field_5dc248358e034{ display: none!important; }
</style>
<?php
}

add_action( 'footer_head', 'footer_head_action_func' );
function footer_head_action_func(){ ?>
<script type='text/javascript'>
</script>
<?php
}

add_action("wp_ajax_save_acfoptions", "save_acfoptions");
add_action("wp_ajax_nopriv_save_acfoptions", "save_acfoptions_login");
function save_acfoptions() {

    if ( !wp_verify_nonce( $_REQUEST['nonce'], "my_user_vote_nonce")) {
        exit();
    }

    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        $result = json_encode($result);
        echo $result;
    }
    else {
        header("Location: ".$_SERVER["HTTP_REFERER"]);
    }

    die();

}

function save_acfoptions_login() {
   echo "You must log in to vote";
   die();
}

/* Ajax send email */
/* Display Vendor Information via Ajax */
add_action( 'wp_ajax_nopriv_send_email_to_team', 'send_email_to_team' );
add_action( 'wp_ajax_send_email_to_team', 'send_email_to_team' );
function send_email_to_team() {
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        $post_id = ($_POST['post_id']) ? $_POST['post_id'] : 0;
        $sentvia = ($_POST['sentvia']) ? $_POST['sentvia'] : '';
        $senderName = ($_POST['fullname']) ? $_POST['fullname'] : '';
        $senderEmail = ($_POST['email']) ? $_POST['email'] : '';
        $subject = ($_POST['subject']) ? $_POST['subject'] : 'Team Contact Form';
        $message = ($_POST['message']) ? $_POST['message'] : '';
        $recipient = get_field("team_email",$post_id);
        $emailTo = ($recipient) ? preg_replace('/\s+/','',$recipient) : '';
        $emailTo = (filter_var($emailTo, FILTER_VALIDATE_EMAIL)) ? $emailTo : '';
        $is_sent = '';
        $is_captcha_ok = '';
        $response['success'] = '';
        $response['error'] = '';
        $response['message'] = '';

        $captchashown = ($_POST['captchashown']) ? $_POST['captchashown'] : '';
        $strcaptcha = ($_POST['strcaptcha']) ? $_POST['strcaptcha'] : '';
        if($strcaptcha) {
            $cstr = preg_replace('/\s+/','',$strcaptcha);
            $cstr = strtoupper($cstr);
            if($captchashown==$cstr) {
                $is_captcha_ok = check_characters_captcha($strcaptcha);
            }
        }
        
        if($is_captcha_ok) {

            $args = array(
                'sender_name'=>$senderName,
                'sender_email'=>$senderEmail,
                'subject'=>$subject,
                'message'=>$message,
                'recipient'=>$emailTo,
                'recipient_id'=>$post_id,
                'sentvia'=>$sentvia
            );

            ob_start();
            echo do_sendmail_to_team($args);
            $is_sent = ob_get_contents();
            ob_end_clean();
            if($is_sent) {
                $response['success'] = 1;
                $response['message'] = '<div class="alert alert-success">Thank you! Your email has been sent successfully.</div>';
            } else {
                $response['message'] = '<div class="alert alert-danger">Message failed to send. Please try again.</div>';
            }

        } else {
            $response['error'] = 'captcha';
            $response['message'] = '<div class="alert alert-danger">Invalid Captcha. Please try again.</div>';
        }

        echo json_encode($response);
    }
    else {
        header("Location: ".$_SERVER["HTTP_REFERER"]);
    }
    die();
}

function do_sendmail_to_team($a) {
    $userIP = get_user_ip();
    //$userCountry = get_user_country_by_ip($userIP);
    $userCountry = '';

    $senderName = $a['sender_name'];
    $senderEmail = $a['sender_email'];
    $emailSubject = $a['subject'];
    $emailBody = $a['message'];
    $recipient = $a['recipient'];
    $recipient_id = $a['recipient_id'];
    $recipientName = ($recipient_id) ? get_the_title($recipient_id) : '';
    $sentvia = $a['sentvia'];
    $isSent = false;
    if($recipient) {
        $to = $recipient;
        $subject = $emailSubject;
        $headers = 'From: Team Contact Form <webform@cmacommunities.com>' . "\r\n";
        $headers .= 'Reply-To: '.$senderEmail . "\r\n";
        $headers .= 'X-Mailer: PHP/' . phpversion() . "\r\n";
        $headers .= "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type: text/html" . "\r\n";
        $message = '<table style="border-collapse: collapse;border:1px solid #98d5e2;max-width:700px;width:100%;font-size:14px;line-height:1.4;"><tbody>';
        $message .= '<tr><td style="padding:10px;background:#f4fdff;"><table>';
        $message .= '<tr><td style="width:85px;vertical-align:top;">Sender Name</td><td style="width:10px;vertical-align:top;">:</td><td style="vertical-align:top;"><strong>'.$senderName.'</strong></td></tr>';
        $message .= '<tr><td style="width:85px;vertical-align:top;">Sender Email</td><td style="width:10px;vertical-align:top;">:</td><td style="vertical-align:top;"><strong>'.$senderEmail.'</strong></td></tr>';
        $message .= '<tr><td style="width:85px;vertical-align:top;">Subject</td><td style="width:10px;vertical-align:top;">:</td><td style="vertical-align:top;"><strong>'.$emailSubject.'</strong></td></tr>';
        if($recipientName) {
            $message .= '<tr><td style="width:85px;vertical-align:top;">Attention</td><td style="width:10px;vertical-align:top;">:</td><td style="vertical-align:top;"><strong>'.$recipientName.'</strong></td></tr>';
        }
        $message .= '<tr><td colspan="3" style="padding:5px 0;"><p style="margin:10px 0px 5px 0px;"><strong>Message:</strong></p>'.$emailBody.'</td></tr>';
        $message .= '</table></td></tr>';
        $message .= '</tbody></table><br>';
        $message .= '<p>This email is sent via <a href="'.$sentvia.'" target="_blank"><i>'.$sentvia.'</i></a> <br>';
        $message .= '<span>User IP: '.$userIP.'</span><br>';
        
        // $geo = get_website_visitor_info($userIP);
        // if($geo) {
        //     $user_country = $geo["geoplugin_countryName"];
        //     $user_city = $geo["geoplugin_city"];
        //     if($user_city) {
        //         $message .= '<span>User City: '.$user_city.'</span><br>';
        //     } 
        //     if($user_country) {
        //         $message .= '<span>User Country: '.$user_country.'</span><br>';
        //     }
        // }
        
        $message .= '</p>';

        if( mail($to, $subject, $message, $headers) ) {
            $isSent = true;
            /* insert to wp_posts */
            $postArgs = array(
                'sender_name'=>$senderName,
                'sender_email'=>$senderEmail,
                'subject'=>$emailSubject,
                'message'=>$emailBody,
                'recipient'=>$recipient,
                'recipient_id'=>$recipient_id,
                'sentvia'=>$sentvia,
                'sender_ip'=>$userIP
            );
            $new_entry_id = insert_user_email_content($postArgs);
        } 
    }
    return $isSent;
}


function insert_user_email_content($a) {
    $new_post = array(
        'post_title'  => $a['sender_name'],
        'post_content'=> $a['message'],
        'post_status' => 'publish',
        'post_type'   => 'teamcontactform'
    );
    $post_id = wp_insert_post($new_post);
    /* add post meta */
    if($post_id) {
        $metas = array(
            'teamcontactform_email_subject'=>$a['subject'],
            'teamcontactform_sender_email'=>$a['sender_email'],
            'teamcontactform_sender_ip'=>$a['sender_ip'],
            'teamcontactform_recipient'=>$a['recipient'],
            'teamcontactform_team_post_id'=>$a['recipient_id'],
        );
        foreach($metas as $key=>$val) {
            if ( !add_post_meta( $post_id, $key, $val, true ) ) { 
               update_post_meta ( $post_id, $key, $val );
            }
        }
    }
    return $post_id;
}


function get_user_ip() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function get_user_country_by_ip($ip) {
    if($ip) {
        $xml = simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=".$ip);
        return ($xml) ? $xml->geoplugin_countryName : "";
    }
}

function get_website_visitor_info($user_ip) {
    //$user_ip = getenv('REMOTE_ADDR');
    $geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=".$user_ip));
    $country = $geo["geoplugin_countryName"];
    $city = $geo["geoplugin_city"];
    return ($geo) ? $geo : '';
}

function check_characters_captcha($str) {
    $out = '';
    if($str) {
        $str = preg_replace('/\s+/','',$str);
        $str = strtoupper($str);
        $permittedchars = permitted_characters();
        if( in_array($str, $permittedchars) ) {
            $out = true;
        }
    }
    return $out;
}

function permitted_characters() {
    $permittedchars = array('AQZCHB','DVCLKT','SBYCQU','VSGJRN','TYFCDX','MMVHHR','AGSABW','AJRBFP','FEUVNF','ZHBCMS','YTHMWY','LYMXGN','HUSYWR','JYTPKE','EWQZJT','DSTMKR','YVQAMG','VZTNAM','LNNBCJ','BPXYWZ','GMCYES','UKLMES','GDLOVU','WKRLME','SRMTAD','URLZDK','PSMALJS','ERTXMC','EZKLVS','SAIAHY','GSWELY','CVQAMY','MNBVCX','QSERTA','ASDJKL');
    return $permittedchars;
}

function get_captcha_strings() {
    $captchaChars = permitted_characters();
    $ccount = count($captchaChars);
    shuffle($captchaChars);
    $captcaVal = $captchaChars[0];
    return $captcaVal;
}
