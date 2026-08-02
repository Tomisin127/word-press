<?php
/**
* GridBit_Customize_Multiple_Select class
*
* @package GridBit WordPress Theme
* @copyright Copyright (C) 2025 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/

class GridBit_Customize_Multiple_Select extends WP_Customize_Control {

public $type = 'gridbit-multiple-select';

public function render_content() {

if ( empty( $this->choices ) )
    return;
?>
    <label>
        <?php if ( ! empty( $this->label ) ) : ?><span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span><?php endif; ?>
        <?php if ( ! empty( $this->description ) ) : ?><span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span><?php endif; ?>
        <select <?php $this->link(); ?> multiple="multiple">
            <?php
                foreach ( $this->choices as $value => $label ) {
                    $selected = ( in_array( $value, $this->value() ) ) ? selected( 1, 1, false ) : '';
                    echo '<option value="' . esc_attr( $value ) . '"' . $selected . '>' . esc_html( $label ) . '</option>'; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */
                }
            ?>
        </select>
    </label>
<?php }

}