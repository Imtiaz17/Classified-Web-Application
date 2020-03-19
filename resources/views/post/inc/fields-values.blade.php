@if (isset($customFields) and $customFields->count() > 0)
<div id="customFields">
	
	<div>
		@foreach($customFields as $field)
            <?php
            if (in_array($field->type, ['radio', 'select'])) {
                if (is_numeric($field->default)) {
                    $option = \App\Models\FieldOption::transById($field->default);
                    if (!empty($option)) {
                        $field->default = $option->value;
                    }
                }
            }
            if (in_array($field->type, ['checkbox'])) {
                $field->default = ($field->default == 1) ? t('Yes') : t('No');
            }
            ?>
			@if ($field->type == 'file')
					<p>
						<strong class="detail-line-label" style="padding-top: 8px;">{{ $field->name }}:</strong>
						<span class="detail-line-value">
							<a class="btn btn-default" href="{{ \Storage::url($field->default) }}" target="_blank">
								<i class="icon-attach-2"></i> {{ t('Download') }}
							</a>
						</span>
					</p>
					
			@else
				@if (!is_array($field->default))
						<p>
							<strong class="detail-line-label">{{ $field->name }}:</strong>
							<span class="detail-line-value">{{ $field->default }}</span>
						</p>
						
				@else
					@if (count($field->default) > 0)
						<p>
							<strong>{{ $field->name }}:</strong>
							<div class="row">
								@foreach($field->default as $valueItem)
									@continue(!isset($valueItem->value))
									<div class="col-col-xs-12 no-margin no-padding">
										<div class="no-margin">
											<i class="fa fa-check"></i> {{ $valueItem->value }}
										</div>
									</div>
								@endforeach
							</div>
						</p>
					@endif
				@endif
			@endif
		@endforeach
	</div>
</div>
@endif
