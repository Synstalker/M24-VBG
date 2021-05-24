<?php ! defined( 'ABSPATH' ) && exit(); ?><div class="totalcontest-settings-item">
    <div class="totalcontest-settings-field">
        <label class="totalcontest-settings-field-label">
			<?php _e( 'Moderation', 'totalcontest' ); ?>
        </label>
        <p>
            <label> <input type="radio" name="" ng-model="editor.settings.contest.submissions.requiresApproval" ng-value="false">
				<?php _e( 'All submissions are publicly visible.', 'totalcontest' ); ?>
                <span class="totalcontest-feature-details" tooltip="<?php esc_attr_e( 'All submissions will be approved automatically.', 'totalcontest' ); ?>">?</span>
            </label>
        </p>
        <p>
            <label> <input type="radio" name="" ng-model="editor.settings.contest.submissions.requiresApproval" ng-value="true" >
				<?php _e( 'Only approved submissions are publicly visible.', 'totalcontest' ); ?>
                
                <span class="totalcontest-feature-details" tooltip="<?php esc_attr_e( 'All submissions will need an approval before going public.', 'totalcontest' ); ?>">?</span>
            </label>
        </p>
    </div>
</div>
<div class="totalcontest-settings-item">
    <div class="totalcontest-settings-field">
        <label class="totalcontest-settings-field-label">
			<?php _e( 'Submission title', 'totalcontest' ); ?>
        </label>
        <input type="text" class="totalcontest-settings-field-input widefat" ng-model="editor.settings.contest.submissions.title">
    </div>
</div>

<div class="totalcontest-settings-item">
    <div class="totalcontest-settings-field">
        <label class="totalcontest-settings-field-label">
			<?php _e( 'Submissions per page', 'totalcontest' ); ?>
        </label>
        <input type="number" min="1" class="totalcontest-settings-field-input widefat" ng-model="editor.settings.contest.submissions.perPage">
    </div>
</div>


<div class="totalcontest-settings-item">
    <div class="totalcontest-settings-field">
        <label class="totalcontest-settings-field-label">
			<?php _e( 'Submission preview', 'totalcontest' ); ?>
        </label>
        <label>
            <input type="radio" name="" ng-model="editor.settings.contest.submissions.preview.source" value="">
			<?php _e( 'No preview', 'totalcontest' ); ?>
            &nbsp;
        </label>
        <label ng-repeat="field in editor.settings.contest.form.fields" ng-if="['image','video','audio','textarea', 'embed'].indexOf(field.type) !== -1">
            <input type="radio" name="" ng-model="editor.settings.contest.submissions.preview.source" ng-value="field.name">
            {{field.label || '<?php _e( 'Untitled', 'totalcontest' ); ?>'}} ({{field.name}})
            &nbsp;
        </label>
    </div>
</div>
<div class="totalcontest-settings-item">
    <div class="totalcontest-settings-field">
        <label class="totalcontest-settings-field-label">
			<?php _e( 'Submission preview fallback (No preview available)', 'totalcontest' ); ?>
        </label>
        <input type="text" class="totalcontest-settings-field-input widefat" placeholder="<?php esc_attr_e( 'URL', 'totalcontest' ); ?>" ng-model="editor.settings.contest.submissions.preview.default">
    </div>
</div>

<div class="totalcontest-settings-item">
    <span class="totalcontest-settings-field-label"><?php _e( 'Editing mode', 'totalcontest' ); ?></span>
    <div class="totalcontest-button-group button-group">
        <button type="button" class="button button-primary-alt button-large" ng-class="{'active': editor.settings.contest.submissions.blocks.enabled}" ng-click="editor.settings.contest.submissions.blocks.enabled = true"><?php _e( 'Blocks', 'totalcontest' ); ?></button>
        <button type="button" class="button button-primary-alt button-large" ng-class="{'active': !editor.settings.contest.submissions.blocks.enabled}" ng-click="editor.settings.contest.submissions.blocks.enabled = false"><?php _e( 'Legacy', 'totalcontest' ); ?></button>
    </div>
</div>

<div class="totalcontest-settings-item" ng-show="!editor.settings.contest.submissions.blocks.enabled">
    <p class="totalcontest-warning"><?php _e( 'This mode has been deprecated and it will be removed soon. Please consider upgrading your template to blocks.', 'totalcontest' ); ?></p>

    <div class="totalcontest-settings-item">
        <div class="totalcontest-settings-field">
            <label class="totalcontest-settings-field-label">
				<?php _e( 'Submission subtitle', 'totalcontest' ); ?>
            </label>
            <input type="text" class="totalcontest-settings-field-input widefat" ng-model="editor.settings.contest.submissions.subtitle">
        </div>
    </div>
    <div class="totalcontest-settings-item">
        <div class="totalcontest-settings-field">
            <label class="totalcontest-settings-field-label">
				<?php _e( 'Submission content', 'totalcontest' ); ?>
                <span class="totalcontest-feature-details" tooltip="<?php esc_attr_e( "This content will be shown in submission's page body.", 'totalcontest' ); ?>">?</span>
            </label>
            <progressive-textarea class="totalcontest-settings-field-input widefat" ng-model="editor.settings.contest.submissions.content"></progressive-textarea>
            <p class="totalcontest-settings-autocomplete">
                <strong><?php _e( 'Insert a form field', 'totalcontest' ); ?></strong>
                <a ng-click="editor.settings.contest.submissions.content = editor.settings.contest.submissions.content + (['image','audio','video', 'embed'].indexOf(field.type) === -1 ? '\{\{fields.' + field.name + '\}\}' : '\{\{contents.' + field.name + '.content\}\}')"
                   ng-repeat="field in editor.settings.contest.form.fields" ng-if="field.name">{{field.name}}</a>
            </p>
        </div>
    </div>
    <div class="totalcontest-settings-item">
        <p><strong><?php _e( 'Template variables', 'totalcontest' ); ?></strong></p>
        <p class="totalcontest-feature-tip" ng-non-bindable><?php _e( '{{id}} for submission ID.', 'totalcontest' ); ?></p>
        <p class="totalcontest-feature-tip" ng-non-bindable><?php _e( '{{fields.FIELD_NAME}} for form fields.', 'totalcontest' ); ?></p>
        <p class="totalcontest-feature-tip" ng-non-bindable><?php _e( '{{user.PROPERTY_NAME}} for a property value in current user.', 'totalcontest' ); ?></p>
        <p class="totalcontest-feature-tip" ng-non-bindable><?php _e( '{{date}} for submission date.', 'totalcontest' ); ?></p>
        <p class="totalcontest-feature-tip" ng-non-bindable><?php _e( '{{time}} for submission time.', 'totalcontest' ); ?></p>
        <p class="totalcontest-feature-tip" ng-non-bindable><?php _e( '{{datetime}} for submission date and time.', 'totalcontest' ); ?></p>
        <p class="totalcontest-feature-tip" ng-non-bindable><?php _e( '{{views}} for submission views.', 'totalcontest' ); ?></p>
        <p class="totalcontest-feature-tip" ng-non-bindable><?php _e( '{{votes}} for submission votes.', 'totalcontest' ); ?></p>
        <p class="totalcontest-feature-tip" ng-non-bindable><?php _e( '{{rate}} for submission rate.', 'totalcontest' ); ?></p>
    </div>
</div>

<div class="totalcontest-settings-item" ng-show="editor.settings.contest.submissions.blocks.enabled">
    <div class="totalcontest-designer">
        <div class="totalcontest-designer-view">
            <div class="totalcontest-designer-context"><?php _e( 'Gallery View', 'totalcontest' ); ?></div>
            <blocks-editor ng-model="editor.settings.contest.submissions.blocks.submissions"></blocks-editor>
        </div>
        <div class="totalcontest-designer-view">
            <div class="totalcontest-designer-context"><?php _e( 'Submission View', 'totalcontest' ); ?></div>
            <blocks-editor ng-model="editor.settings.contest.submissions.blocks.submission"></blocks-editor>
        </div>
    </div>
</div>

<script type="text/ng-template" id="blocks-editor-template">
    <div class="totalcontest-designer-builder" ng-class="{'is-menu-open': $ctrl.isMenuOpen}">
        <div class="totalcontest-designer-builder-blocks" dnd-list="blocks" dnd-allowed-types="['text', 'title', 'subtitle', 'button', 'embed', 'image']">
            <div class="totalcontest-designer-builder-blocks-item"
                 ng-repeat="block in blocks"
                 ng-include="'designer-component-' + block.type + '-template'"
                 dnd-draggable="block"
                 dnd-type="block.type"
                 dnd-effect-allowed="move"
                 dnd-moved="$ctrl.remove($index)">

            </div>
            <div class="dndPlaceholder totalcontest-designer-builder-blocks-placeholder">
                <div class="totalcontest-list-placeholder-text">
					<?php _e( 'Move here', 'totalcontest' ); ?>
                </div>
            </div>
        </div>
        <div class="totalcontest-designer-builder-footer" ng-class="{active: $ctrl.isMenuOpen}">
            <div class="totalcontest-designer-builder-add" ng-click="$ctrl.isMenuOpen = !$ctrl.isMenuOpen">
                <span class="dashicons dashicons-plus"></span>
                <span><?php _e( 'Add new block', 'totalcontest' ); ?></span>
            </div>
            <div class="totalcontest-designer-builder-components">
                <div class="totalcontest-designer-builder-components-item" ng-click="$ctrl.add('text')">
                    <button type="button" class="button">
						<?php _e( 'Text', 'totalcontest' ); ?>
                    </button>
                </div>
                <div class="totalcontest-designer-builder-components-item" ng-click="$ctrl.add('title')">
                    <button type="button" class="button">
						<?php _e( 'Title', 'totalcontest' ); ?>
                    </button>
                </div>
                <div class="totalcontest-designer-builder-components-item" ng-click="$ctrl.add('subtitle')">
                    <button type="button" class="button">
						<?php _e( 'Subtitle', 'totalcontest' ); ?>
                    </button>
                </div>
                <div class="totalcontest-designer-builder-components-item" ng-click="$ctrl.add('image')">
                    <button type="button" class="button">
						<?php _e( 'Image', 'totalcontest' ); ?>
                    </button>
                </div>
                <div class="totalcontest-designer-builder-components-item" ng-click="$ctrl.add('embed')">
                    <button type="button" class="button">
						<?php _e( 'Embed', 'totalcontest' ); ?>
                    </button>
                </div>
                <div class="totalcontest-designer-builder-components-item" ng-click="$ctrl.add('raw')">
                    <button type="button" class="button">
						<?php _e( 'Raw', 'totalcontest' ); ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
</script>

<script type="text/ng-template" id="designer-component-image-template">
    <div class="totalcontest-designer-builder-blocks-item-header">
        <span class="dashicons dashicons-move totalcontest-designer-builder-blocks-item-handle" dnd-handle></span>
        <div class="totalcontest-designer-builder-blocks-item-type" dnd-nodrag>
            <span class="dashicons dashicons-format-image"></span>
			<?php _e( 'Image', 'totalcontest' ); ?>
        </div>
        <div class="totalcontest-designer-builder-blocks-item-remove" dnd-nodrag ng-click="$ctrl.remove($index, true, $event)">
            <span class="dashicons dashicons-trash"></span>
        </div>
    </div>
    <div class="totalcontest-designer-builder-blocks-item-body" dnd-nodrag>
        <div class="totalcontest-settings-field">
            <label class="totalcontest-settings-field-label" for="component-{{block.uid}}-source">
				<?php _e( 'Source', 'totalcontest' ); ?>
            </label>
            <select id="component-{{block.uid}}-source" class="totalcontest-settings-field-input widefat" ng-model="block.source">
                <optgroup label="<?php esc_attr_e( 'Other', 'totalcontest' ); ?>">
                    <option value=""><?php _e( 'No preview', 'totalcontest' ) ?></option>
                    <option value="custom"><?php _e( 'Custom', 'totalcontest' ) ?></option>
                </optgroup>
                <optgroup label="<?php esc_attr_e( 'Images', 'totalcontest' ); ?>">
                    <option value="{{suggestion}}" ng-repeat="suggestion in $ctrl.suggestions.images">{{$ctrl.labels[suggestion] || suggestion}}</option>
                </optgroup>
            </select>
        </div>
        <div class="totalcontest-settings-field" ng-if="block.source == 'custom'">
            <label class="totalcontest-settings-field-label" for="component-{{block.uid}}-custom">
				<?php _e( 'Custom image', 'totalcontest' ); ?>
            </label>
            <input type="text" id="component-{{block.uid}}-custom" class="totalcontest-settings-field-input widefat" ng-model="block.custom">
        </div>
        <div class="totalcontest-settings-field" ng-if="block.source && block.source != '' && block.source != 'custom'">
            <label class="totalcontest-settings-field-label" for="component-{{block.uid}}-fallback">
				<?php _e( 'Fallback', 'totalcontest' ); ?>
            </label>
            <input type="text" id="component-{{block.uid}}-fallback" class="totalcontest-settings-field-input widefat" ng-model="block.fallback">
        </div>
    </div>
</script>

<script type="text/ng-template" id="designer-component-embed-template">
    <div class="totalcontest-designer-builder-blocks-item-header">
        <span class="dashicons dashicons-move totalcontest-designer-builder-blocks-item-handle" dnd-handle></span>
        <div class="totalcontest-designer-builder-blocks-item-type" dnd-nodrag>
            <span class="dashicons dashicons-editor-code"></span>
			<?php _e( 'Embed', 'totalcontest' ); ?>
        </div>
        <div class="totalcontest-designer-builder-blocks-item-remove" dnd-nodrag ng-click="$ctrl.remove($index, true, $event)">
            <span class="dashicons dashicons-trash"></span>
        </div>
    </div>
    <div class="totalcontest-designer-builder-blocks-item-body" dnd-nodrag>
        <div class="totalcontest-settings-field">
            <label class="totalcontest-settings-field-label" for="component-{{block.uid}}-source">
				<?php _e( 'Source', 'totalcontest' ); ?>
            </label>
            <select id="component-{{block.uid}}-source" class="totalcontest-settings-field-input widefat" ng-model="block.source">
                <optgroup label="<?php esc_attr_e( 'Contents', 'totalcontest' ); ?>">
                    <option value="{{suggestion}}" ng-repeat="suggestion in $ctrl.suggestions.contents">{{$ctrl.labels[suggestion] || suggestion}}</option>
                </optgroup>
            </select>
        </div>

        <div class="totalcontest-settings-field">
            <label class="totalcontest-settings-field-label" for="component-{{block.uid}}-aspect-ratio">
				<?php _e( 'Aspect ratio', 'totalcontest' ); ?>
            </label>
            <select id="component-{{block.uid}}-aspect-ratio" class="totalcontest-settings-field-input widefat" ng-model="block.aspectRatio">
                <option value=""><?php _e( 'N/A', 'totalcontest' ) ?></option>
                <option value="21by9"><?php _e( '21:9', 'totalcontest' ) ?></option>
                <option value="16by9"><?php _e( '16:9', 'totalcontest' ) ?></option>
                <option value="4by3"><?php _e( '4:3', 'totalcontest' ) ?></option>
                <option value="1by1"><?php _e( '1:1', 'totalcontest' ) ?></option>
            </select>
        </div>
    </div>
</script>

<script type="text/ng-template" id="designer-component-raw-template">
    <div class="totalcontest-designer-builder-blocks-item-header">
        <span class="dashicons dashicons-move totalcontest-designer-builder-blocks-item-handle" dnd-handle></span>
        <div class="totalcontest-designer-builder-blocks-item-type" dnd-nodrag>
            <span class="dashicons dashicons-editor-code"></span>
			<?php _e( 'Raw', 'totalcontest' ); ?>
        </div>
        <div class="totalcontest-designer-builder-blocks-item-remove" dnd-nodrag ng-click="$ctrl.remove($index, true, $event)">
            <span class="dashicons dashicons-trash"></span>
        </div>
    </div>
    <ng-include src="'designer-expressions-builder-template'"/>
</script>

<script type="text/ng-template" id="designer-component-text-template">
    <div class="totalcontest-designer-builder-blocks-item-header">
        <span class="dashicons dashicons-move totalcontest-designer-builder-blocks-item-handle" dnd-handle></span>
        <div class="totalcontest-designer-builder-blocks-item-type" dnd-nodrag>
            <span class="dashicons dashicons-editor-alignleft"></span>
			<?php _e( 'Text', 'totalcontest' ); ?>
        </div>
        <div class="totalcontest-designer-builder-blocks-item-remove" dnd-nodrag ng-click="$ctrl.remove($index, true, $event)">
            <span class="dashicons dashicons-trash"></span>
        </div>
    </div>
    <ng-include src="'designer-expressions-builder-template'"/>
</script>

<script type="text/ng-template" id="designer-component-title-template">
    <div class="totalcontest-designer-builder-blocks-item-header">
        <span class="dashicons dashicons-move totalcontest-designer-builder-blocks-item-handle" dnd-handle></span>
        <div class="totalcontest-designer-builder-blocks-item-type" dnd-nodrag>
            <span class="dashicons dashicons-editor-textcolor"></span>
			<?php _e( 'Title', 'totalcontest' ); ?>
        </div>
        <div class="totalcontest-designer-builder-blocks-item-remove" dnd-nodrag ng-click="$ctrl.remove($index, true, $event)">
            <span class="dashicons dashicons-trash"></span>
        </div>
    </div>
    <ng-include src="'designer-expressions-builder-template'"/>
</script>

<script type="text/ng-template" id="designer-component-subtitle-template">
    <div class="totalcontest-designer-builder-blocks-item-header">
        <span class="dashicons dashicons-move totalcontest-designer-builder-blocks-item-handle" dnd-handle></span>
        <div class="totalcontest-designer-builder-blocks-item-type" dnd-nodrag>
            <span class="dashicons dashicons-editor-ltr"></span>
			<?php _e( 'Subtitle', 'totalcontest' ); ?>
        </div>
        <div class="totalcontest-designer-builder-blocks-item-remove" dnd-nodrag ng-click="$ctrl.remove($index, true, $event)">
            <span class="dashicons dashicons-trash"></span>
        </div>
    </div>
    <ng-include src="'designer-expressions-builder-template'"/>
</script>

<script type="text/ng-template" id="designer-expressions-builder-template">
    <div class="totalcontest-designer-builder-blocks-item-body" dnd-nodrag>
        <div class="totalcontest-settings-field">
            <label class="totalcontest-settings-field-label" for="component-{{block.uid}}-custom">
				<?php _e( 'Source', 'totalcontest' ); ?>
            </label>
            <div class="totalcontest-designer-dynamic-field" id="component-{{block.uid}}-custom" dnd-list="block.expressions" dnd-horizontal-list="true" dnd-allowed-types="['val', 'var']">
                <div class="totalcontest-designer-dynamic-field-item totalcontest-designer-dynamic-field-item-type-{{expression.type}}"
                     ng-repeat="(expressionIndex, expression) in block.expressions"
                     dnd-draggable="expression"
                     dnd-type="expression.type"
                     dnd-effect-allowed="move"
                     dnd-moved="$ctrl.removeExpression(block, $index)"
                     ng-include="'designer-expression-' + expression.type + '-template'">

                </div>

                <div class="dndPlaceholder totalcontest-designer-dynamic-field-placeholder"></div>

                <div class="totalcontest-designer-dynamic-field-add">
                    <div class="totalcontest-designer-dynamic-field-action">
                        <span class="dashicons dashicons-plus"></span>
                    </div>
                    <div class="totalcontest-designer-dynamic-field-action-menu">
                        <div class="totalcontest-designer-dynamic-field-action-menu-item" ng-click="$ctrl.addExpression(block, 'var')"><?php _e( 'Variable', 'totalcontest' ); ?></div>
                        <div class="totalcontest-designer-dynamic-field-action-menu-item" ng-click="$ctrl.addExpression(block, 'val')"><?php _e( 'Custom', 'totalcontest' ); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</script>

<script type="text/ng-template" id="designer-expression-var-template">
    <span class="dashicons dashicons-move totalcontest-designer-dynamic-field-item-handle" dnd-handle></span>
    <span class="dashicons dashicons-tag totalcontest-designer-dynamic-field-item-icon"></span>
    <span class="totalcontest-designer-dynamic-field-item-placeholder">{{$ctrl.labels[expression.source] || expression.source}}</span>
    <select dnd-nodrag class="totalcontest-designer-dynamic-field-item-input" name="" id="" ng-model="expression.source">
        <optgroup label="<?php esc_attr_e( 'Basics', 'totalcontest' ); ?>">
            <option value="{{suggestion}}" ng-repeat="suggestion in $ctrl.suggestions.basics">{{$ctrl.labels[suggestion] || suggestion}}</option>
        </optgroup>
        <optgroup label="<?php esc_attr_e( 'Fields', 'totalcontest' ); ?>">
            <option value="{{suggestion}}" ng-repeat="suggestion in $ctrl.suggestions.fields">{{$ctrl.labels[suggestion] || suggestion}}</option>
        </optgroup>
        <optgroup label="<?php esc_attr_e( 'Contents', 'totalcontest' ); ?>">
            <option value="{{suggestion}}" ng-repeat="suggestion in $ctrl.suggestions.contents">{{$ctrl.labels[suggestion] || suggestion}}</option>
        </optgroup>
        <optgroup label="<?php esc_attr_e( 'Other', 'totalcontest' ); ?>">
            <option value="{{suggestion}}" ng-repeat="suggestion in $ctrl.suggestions.other">{{$ctrl.labels[suggestion] || suggestion}}</option>
        </optgroup>
    </select>
    <div dnd-nodrag class="totalcontest-designer-dynamic-field-item-close" ng-click="$ctrl.removeExpression(block, expressionIndex, true, $event)">&times;</div>
</script>

<script type="text/ng-template" id="designer-expression-val-template">
    <span class="dashicons dashicons-move totalcontest-designer-dynamic-field-item-handle" dnd-handle></span>
    <textarea dnd-nodrag ng-trim="false" rows="1" type="text" class="totalcontest-designer-dynamic-field-item-input" name="" id="" ng-model="expression.source"></textarea>
    <div class="totalcontest-designer-dynamic-field-item-placeholder" ng-bind-html="$ctrl.normalize(expression.source)"></div>
    <div dnd-nodrag class="totalcontest-designer-dynamic-field-item-close" ng-click="$ctrl.removeExpression(block, expressionIndex, true, $event)">&times;</div>
</script>
