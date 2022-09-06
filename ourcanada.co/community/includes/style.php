 <style type="text/css">
   .image_grid_header_absolute.lazy{
    width: 100%;
    height: 100%;
   }
 </style>
 <link rel="icon" href="<?php echo $cms_url ?>assets/img/favicon.ico" type="image/x-icon">
   <!-- Stylesheets-->
<!---->
<!--<link rel="preconnect" href="https://fonts.gstatic.com">-->
<!--<link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">-->
<!--<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400&display=swap" rel="stylesheet">-->

 <style>
     /* latin-ext */
     @font-face {
         font-family: 'Lato';
         font-style: normal;
         font-weight: 300;
         font-display: swap;
         src: url(https://fonts.gstatic.com/s/lato/v17/S6u9w4BMUTPHh7USSwaPGR_p.woff2) format('woff2');
         unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
     }
     /* latin */
     @font-face {
         font-family: 'Lato';
         font-style: normal;
         font-weight: 300;
         font-display: swap;
         src: url(https://fonts.gstatic.com/s/lato/v17/S6u9w4BMUTPHh7USSwiPGQ.woff2) format('woff2');
         unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
     }
     /* latin-ext */
     @font-face {
         font-family: 'Lato';
         font-style: normal;
         font-weight: 400;
         font-display: swap;
         src: url(https://fonts.gstatic.com/s/lato/v17/S6uyw4BMUTPHjxAwXjeu.woff2) format('woff2');
         unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
     }
     /* latin */
     @font-face {
         font-family: 'Lato';
         font-style: normal;
         font-weight: 400;
         font-display: swap;
         src: url(https://fonts.gstatic.com/s/lato/v17/S6uyw4BMUTPHjx4wXg.woff2) format('woff2');
         unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
     }
     /* latin-ext */
     @font-face {
         font-family: 'Lato';
         font-style: normal;
         font-weight: 700;
         font-display: swap;
         src: url(https://fonts.gstatic.com/s/lato/v17/S6u9w4BMUTPHh6UVSwaPGR_p.woff2) format('woff2');
         unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
     }
     /* latin */
     @font-face {
         font-family: 'Lato';
         font-style: normal;
         font-weight: 700;
         font-display: swap;
         src: url(https://fonts.gstatic.com/s/lato/v17/S6u9w4BMUTPHh6UVSwiPGQ.woff2) format('woff2');
         unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
     }

     /* devanagari */
     @font-face {
         font-family: 'Poppins';
         font-style: normal;
         font-weight: 100;
         font-display: swap;
         src: url(https://fonts.gstatic.com/s/poppins/v15/pxiGyp8kv8JHgFVrLPTucXtAKPY.woff2) format('woff2');
         unicode-range: U+0900-097F, U+1CD0-1CF6, U+1CF8-1CF9, U+200C-200D, U+20A8, U+20B9, U+25CC, U+A830-A839, U+A8E0-A8FB;
     }
     /* latin-ext */
     @font-face {
         font-family: 'Poppins';
         font-style: normal;
         font-weight: 100;
         font-display: swap;
         src: url(https://fonts.gstatic.com/s/poppins/v15/pxiGyp8kv8JHgFVrLPTufntAKPY.woff2) format('woff2');
         unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
     }
     /* latin */
     @font-face {
         font-family: 'Poppins';
         font-style: normal;
         font-weight: 100;
         font-display: swap;
         src: url(https://fonts.gstatic.com/s/poppins/v15/pxiGyp8kv8JHgFVrLPTucHtA.woff2) format('woff2');
         unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
     }
     /* devanagari */
     @font-face {
         font-family: 'Poppins';
         font-style: normal;
         font-weight: 200;
         font-display: swap;
         src: url(https://fonts.gstatic.com/s/poppins/v15/pxiByp8kv8JHgFVrLFj_Z11lFc-K.woff2) format('woff2');
         unicode-range: U+0900-097F, U+1CD0-1CF6, U+1CF8-1CF9, U+200C-200D, U+20A8, U+20B9, U+25CC, U+A830-A839, U+A8E0-A8FB;
     }
     /* latin-ext */
     @font-face {
         font-family: 'Poppins';
         font-style: normal;
         font-weight: 200;
         font-display: swap;
         src: url(https://fonts.gstatic.com/s/poppins/v15/pxiByp8kv8JHgFVrLFj_Z1JlFc-K.woff2) format('woff2');
         unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
     }
     /* latin */
     @font-face {
         font-family: 'Poppins';
         font-style: normal;
         font-weight: 200;
         font-display: swap;
         src: url(https://fonts.gstatic.com/s/poppins/v15/pxiByp8kv8JHgFVrLFj_Z1xlFQ.woff2) format('woff2');
         unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
     }
     /* devanagari */
     @font-face {
         font-family: 'Poppins';
         font-style: normal;
         font-weight: 300;
         font-display: swap;
         src: url(https://fonts.gstatic.com/s/poppins/v15/pxiByp8kv8JHgFVrLDz8Z11lFc-K.woff2) format('woff2');
         unicode-range: U+0900-097F, U+1CD0-1CF6, U+1CF8-1CF9, U+200C-200D, U+20A8, U+20B9, U+25CC, U+A830-A839, U+A8E0-A8FB;
     }
     /* latin-ext */
     @font-face {
         font-family: 'Poppins';
         font-style: normal;
         font-weight: 300;
         font-display: swap;
         src: url(https://fonts.gstatic.com/s/poppins/v15/pxiByp8kv8JHgFVrLDz8Z1JlFc-K.woff2) format('woff2');
         unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
     }
     /* latin */
     @font-face {
         font-family: 'Poppins';
         font-style: normal;
         font-weight: 300;
         font-display: swap;
         src: url(https://fonts.gstatic.com/s/poppins/v15/pxiByp8kv8JHgFVrLDz8Z1xlFQ.woff2) format('woff2');
         unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
     }
     /* devanagari */
     @font-face {
         font-family: 'Poppins';
         font-style: normal;
         font-weight: 400;
         font-display: swap;
         src: url(https://fonts.gstatic.com/s/poppins/v15/pxiEyp8kv8JHgFVrJJbecmNE.woff2) format('woff2');
         unicode-range: U+0900-097F, U+1CD0-1CF6, U+1CF8-1CF9, U+200C-200D, U+20A8, U+20B9, U+25CC, U+A830-A839, U+A8E0-A8FB;
     }
     /* latin-ext */
     @font-face {
         font-family: 'Poppins';
         font-style: normal;
         font-weight: 400;
         font-display: swap;
         src: url(https://fonts.gstatic.com/s/poppins/v15/pxiEyp8kv8JHgFVrJJnecmNE.woff2) format('woff2');
         unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
     }
     /* latin */
     @font-face {
         font-family: 'Poppins';
         font-style: normal;
         font-weight: 400;
         font-display: swap;
         src: url(https://fonts.gstatic.com/s/poppins/v15/pxiEyp8kv8JHgFVrJJfecg.woff2) format('woff2');
         unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
     }
 <?php

echo file_get_contents($cms_url."/assets/css/bootstrap.css");
 echo file_get_contents($cms_url."/assets/css/responsive.css");
 echo file_get_contents($cms_url."/assets/css/main.css");
 echo file_get_contents($cms_url."/assets/css/demo4.css");
 echo file_get_contents($cms_url."/assets/css/demo5.css");
  echo file_get_contents($cms_url."/assets/css/style.css");



 ?>
 </style>
<!--   <link rel="stylesheet" href="--><?php //echo $cms_url ?><!--assets/css/bootstrap.css" type="text/css" media="all" />-->
<!--   <link rel="stylesheet" href="--><?php //echo $cms_url ?><!--assets/css/style.css" type="text/css" media="all" />-->
<!--   <link rel="stylesheet" href="--><?php //echo $cms_url ?><!--assets/css/responsive.css" type="text/css" media="all" />-->
<!--   <link rel="stylesheet" href="--><?php //echo $cms_url ?><!--assets/css/main.css" type="text/css" media="all" />-->
<!--   <link rel="stylesheet" href="--><?php //echo $cms_url ?><!--assets/css/demo4.css" type="text/css" media="all" />-->
<!---->
<!--   <link rel="stylesheet"  href="--><?php //echo $cms_url?><!--assets/css/demo5.css" type="text/css" media="all" />-->
   <style>
       
       .image-post-title a
       {
               word-break: break-word;
       }
       .word_space{
        word-spacing: 15px;
       }
       #language-picker-select{
        position: absolute;
        left: 0;
        top: 4px;
        width: auto;
       }
       <?php if(getCurLang($langURL,true) == 'arabic'){ ?>
        .item-details{
          margin-left: 0;
          margin-right: 30px;
        }
      <?php } ?>
      .text-doted{
        width: 100%;
        overflow:hidden; 
        white-space:nowrap; 
        text-overflow: ellipsis;
      }
      .feature-post-title a{
        width: 100%;
        display: block;
      }
       /*.logo_link img*/
       /*{*/
           /*width: 40%;*/
       /*}*/
       @media screen and (max-width: 950px) {
            #sidebar{
                width: 100%;
            }
        }
   </style>