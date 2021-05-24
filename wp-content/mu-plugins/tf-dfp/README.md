# 24 DFP WordPress Plugin #

* WordPress plugin to manage, test and display DFP ads.

## For Developers ##

### Installation ###
```
git submodule init;
git submodule add git@bitbucket.org:24dotcom/tf-dfp.git wp-content/plugins/tf-dfp;
git submodule update --init --recursive;
```

### Plugin Configuration ###

| Config         | Value                                                       |
|----------------|-------------------------------------------------------------|
| Desktop Prefix | /8900/Media24/Web/main-site-domain-and-tld/Subdomain        |
| Tablet Prefix  | /8900/Media24/Mobile-Web/main-site-domain-and-tld/Subdomain |
| Mobile Prefix  | /8900/Media24/Mobile-Web/main-site-domain-and-tld/Subdomain |


### Common Ad Units ###

| Ad Units    | Value |
|-------------|-------|
| Out of Page |       |


| Available Ad Units:  | Value                         | Mobile | Tablet | Desktop |
|----------------------|-------------------------------|--------|--------|---------|
| Take Over 1000x1000  | site-identifier-ad-1000x1000 | no     | no     | yes     |
| Leaderboard 728x90   | site-identifier-ad-728x90    | no     | no     | yes     |
| Half Page 300x600    | site-identifier-ad-300x600   | no     | no     | yes     |
| Leaderboard 320x50   | site-identifier-ad-320x50-m  | yes    | yes    | no      |


### Common Widgets and Sidebars configurations

| Sidebar Name            | Ad Unit                                    | Key | Value |
|-------------------------|--------------------------------------------|-----|-------|
| Shop Sidebar            | 300x600 / site-identifier-ad-300x600-1     |     |       |
| 24 DFP Special Ads      | 1000x1000 / site-identifier-ad-1000x1000-1 |     |       |
| 24 DFP Header           | 728x90 / site-identifier-ad-728x90-1       |     |       |
| 24 DFP Articles Listing |                                            |     |       |


### Debugging
To view the currently loaded ads on the site, just append ``?googfc`` to the url


### Add this to templates within the loop ###
```php
/* TF_DFP - start */
if( class_exists('TF_DFP_Widget') &&  is_active_sidebar('tf_dfp_artlist_sb') ) {
    $post_counter = $post_counter === null ? 1 : ++$post_counter;
    $tf_dfp_config_count = 4; //Make configurable
    if( $post_counter === $tf_dfp_config_count ) {
        dynamic_sidebar('tf_dfp_artlist_sb');
    }
}
/* TF_DFP - end */
```

### Add this to header where Leaderboards need to display ###
```php
/* TF_DFP - start */
if( class_exists( 'TF_DFP_Widget' ) &&  is_active_sidebar( 'tf_dfp_head_sb' ) ) {
    dynamic_sidebar('tf_dfp_head_sb');
}
/* TF_DFP - end */
```


## [Troubleshooting](https://bitbucket.org/24dotcom/tf-dfp/wiki/Troubleshooting) ##
Please refer to the wiki: https://bitbucket.org/24dotcom/tf-dfp/wiki/Troubleshooting