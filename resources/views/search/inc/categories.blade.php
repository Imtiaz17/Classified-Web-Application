
<?php
if (!isset($cats)) {
    $cats = collect([]);
}

$cats = $cats->groupBy('parent_id');
$subCats = $cats;
if ($cats->has(0)) {
	$cats = $cats->get(0);
}
if ($subCats->has(0)) {
	$subCats = $subCats->forget(0);
}
?>
<?php
	if (
		(isset($subCats) and !empty($subCats) and isset($cat) and !empty($cat) and $subCats->has($cat->id)) ||
		(isset($cats) and !empty($cats))
	):
?>
	<div class="row">
		<div class="col-sm-6">
			<div id="catsList" class="categories-list list-filter">
				@if (isset($subCats) and !empty($subCats) and isset($cat) and !empty($cat))
                <strong><a href="/category/{{$cat->slug}}">{{$cat->name}}</a></strong>
                @else
                 <strong><a href="">Select category</a></strong>
                @endif
               
				<ul class="list-unstyled">
				@if (isset($subCats) and !empty($subCats) and isset($cat) and !empty($cat))
					@if ($subCats->has($cat->tid))
						@foreach ($subCats->get($cat->tid) as $iSubCat)
							<li>
								<a  href="/category/{{$cat->slug}}/{{$iSubCat->slug}}">
									{{ $iSubCat->name }}
								</a>
							</li>
						@endforeach
					@endif
				@else
					@if (isset($cats) and !empty($cats))
						@foreach ($cats as $iCategory)
							<li>
								<a  onclick="getCategory('{{ $iCategory->id }}')">
									{{ $iCategory->name }}
								</a>
							</li>
						@endforeach
					@endif
				@endif
			</ul>
			</div>
		</div>
		<div class="col-sm-6">
			<div id="subcat" style="display: none">
				<p style="color: #4a84b5;"><strong>Select a subcategory</strong></p>
			</div>
			<div id="showCategory" style="margin-top: -9px"></div>
		</div>
	</div>

<script type="text/javascript">
	function getCategory( id){
		 $('#showCategory').empty();
		 $.ajax({
        type: "POST", 
        dataType: "html",
        url:'ajax/category/'+ id,
        data: {
          id:id,
          _token: '{{csrf_token()}}'
        },

        success: function (data) {
        	$('#subcat').css("display","block");
            $('#showCategory').append(data);

         },
           
      });
		
	}
</script>
@push('after_scripts')
@endpush

<?php endif; ?>