=== Simple Bootstrap 4 Shortcodes ===
Contributors: tweakitguy
Tags: Bootstrap, shortcode
Requires at least: 4.9.2
Requires PHP: 5.3

Simple Bootstrap 4.0 shortcodes based off original plugin by Michael W. Delaney, Filip Stefansson, and Simon Yeldon

== Description ==
Simple Bootstrap 4.0 shortcodes with various attribute options.

Codes include:
- Container
- Row
- Column
- Accordion
- Card
- Alert
- Badge
- Button
- Button Group
- Carousel & carousel items
- Quick responsive embed

## General

- Plugin does not include Bootstrap library, be sure to include with your theme
- Bootstrap v4.0.0 https://getbootstrap.com/docs/4.0/
- Only the most commonly used items & attributes have been included


## ALERT
`[alert type=danger dismissable=true class="custom_class"]`
`[/alert]`

| Attribute | Tag | Options |
| --------- | ---- | ------- |
| Alert type | type | primary, secondary, **success**, danger, warning, info, light, dark |
| Dismiss button | dismissable | true, **false** |
| Custom class | class | |

## BADGE
`[badge type=danger pill=false url="http://" class="custom_class"]`

| Attribute | Tag | Options |
| --------- | ---- | ------- |
| Badge type | type | primary, secondary, success, danger, warning, info, light, dark |
| Pill badge | pill | true, **false** |
| Hyperlink | url | |
| Custom class | class | |

## BUTTON
`[button type=danger pill=false url="http://" class="custom_class"]`

| Attribute | Tag | Options |
| --------- | ---- | ------- |
| Button type | type | primary, secondary, success, danger, warning, info, light, dark, outline-* |
| Size | size | sm, lg |
| Hyperlink | url | |
| Full width | block | true, false |
| Target | target | _parent, _blank, etc |
| Disabled | disabled | true, false |
| Active | active | true, false |
| Custom class | class | |

## BUTTON GROUP
`[button_group type=danger pill=false url="http://" class="custom_class"]`
`[/button_group]`

| Attribute | Tag | Options |
| --------- | ---- | ------- |
| Size | size | sm, md, lg, xl |
| Hyperlink | url | |
| Vertical | vertical | true, false |
| Custom class | class | |

## CAROUSEL
```
[carousel id="my_id" controls=true class="custom_class"]
[carousel_item active=true img=http:// caption="My first image" class="custom_class"]
[carousel_item img=http:// caption="My second image"]
[carousel_item img=http:// caption="My third image"]
[/carousel]
```


## CONTAINER
`[container fluid='true' class='custom_classes' id='custom_id']`
`[/container]`

## ROW
`[row gutters='false' justify='start' class='custom_classes' id='custom_id']`
`[/row]`

| Attribute | Tag | Options |
| --------- | ---- | ------- |
| Gutters | gutters | **true**, false |
| Justify Content | justify | start, center, end, around, between |
| Custom class | class| |

- Use custom classes for content justification at different breakpoints
- align-items not included, use custom class

## COLUMN
`[column num="4" xs="12" offset_xl="2" order="1" class="custom_classes" id='custom_id']`
`[/column]`

| Attribute | Tag | Options |
| --------- | ---- | ------- |
| Columns | col, sm - xl | auto,1 - 12 |
| Offset - col, sm - xl | offset, offset_sm - xl | 1 - 12 |
| Order - order, sm - xl | order, order_sm - xl | 1 - 12, first, last |
| Custom class| class | |

- Omitting attributes will use auto-layout
- Not programmed
    - align items
    - margin utilities
    - Nesting

## Accordion
To be used along with [card].  Note, that id must match acc_id in [card].
`[accordion class="custom_class" id="custom_id"]`
`[/accordion]`

## Card
Can be used independent to make a collapsible element or with an accordion.
`[card title="My Title" acc_id="Accordion_ID" id="card_id"]`
`[/card]`

###Output
```
<div class="card" id="card_id">
    <div class="card-header" id="heading_XXX">
        <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#collapse_XXX" aria-expanded="true" aria-controls="collapse_XXX">
                My Title
            </button>
        </h5>
    </div>
    <div id="collapse_XXX" class="collapse" aria-labelledby="heading_XXX" data-parent="#Accordion_ID">
        <div class="card-body">
            CONTENT
        </div>
    </div>
</div>
```

## Embed
Can be used to encapsulate content or automatically buy supplying a URL.
`[embed url='http://www.youtube.com/video' size='21by9' id='custom_id' class='custom_class']`
####OR
`[embed size='4by3']`
`[/embed]`


| Attribute | Tag | Options |
| --------- | ---- | ------- |
| Ratio | size | 21by9, 16by9, 4by3, **1by1** |
| Source | url | http string |
| Custom class | class | |
| Custom id | id | |


# Future potential add-ons

- w-100
- Media objects
- Tables
- Images & Figures
- Breadcrumb


# Code Snippet

The following code can be added to help when using WP media inserts

```
// remove size attributes when adding media to posts
function mv_bs_remove_width_attribute( $html ) {
    $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
    return $html;
}
add_filter( 'post_thumbnail_html', 'mv_bs_remove_width_attribute', 10 );
add_filter( 'image_send_to_editor', 'mv_bs_remove_width_attribute', 10 );

// Adds img-fluid to class when adding media to posts
function mv_bs_add_image_responsive_class($content) {
    $pattern ="/<img(.*?)class=\"(.*?)\"(.*?)>/i";
    $replacement = '<img$1class="$2 img-fluid"$3>';
    $content = preg_replace($pattern, $replacement, $content);
    return $content;
}
add_filter('the_content', 'mv_bs_add_image_responsive_class');
```

== Installation ==
1. Install plugin
2. (optional) enable additional code to make images responsive
3. Use shortcodes
