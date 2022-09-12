<?php $table = $searchData['table']; 
$url = Request::fullUrl('admin."'.$searchData['module'].'"');
?>

<div id="myModal" style="display:none;">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <form name="search" id="Search">
                <input type="hidden" name="table_name" value="{{ $table }}">
                <table class="table search-table table-hover" id="advance-search">
	                <tbody>
                    <?php
                        foreach($searchData['searchable_field'] as $fieldKey=>$fieldValue)
                        { 
                    ?>
                            <tr id="{{ $fieldValue['column_name'] }}" class="fieldsearch">
                                <td>{{ $fieldValue['label']}} </td>
                                <td> 
                                    <select name="operate" class="form-control input-sm oper" id="{{ $fieldValue['column_name'] }}_operate" onchange="changeOperate(this.value , '{{ $fieldValue['column_name'] }}', '{{ @$fieldValue['lookup-table'] }}')">
                                        @if($fieldValue['type'] != 'text_date'))
                                        <option value="equal"> = </option>
                                        @endif
                                        @if(isset($fieldValue['is_number']))
                                        <option value="bigger_equal"> >= </option>
                                        <option value="smaller_equal"> <= </option>
                                        <option value="smaller"> < </option>
                                        <option value="bigger"> > </option>
                                        @endif
                                       <!--  @if($fieldValue['type'] != 'select' && $fieldValue['type'] != 'text_date'))
                                        <option value="not_null"> ! Null  </option>
                                        <option value="is_null"> Null </option>
                                        @endif -->
                                        @if(isset($fieldValue['is_date']))
                                        <option value="between"> Between </option>
                                        @endif
                                        @if(!isset($fieldValue['is_date']))
                                        <option value="like"> Like </option>	
                                        @endif
                                    </select> 
                                </td>
                                <td id="field_{{ $fieldValue['column_name'] }}">{!! Common::buildSearchFields($fieldKey , $searchData['searchable_field']) !!}</td>
                                <!-- <input type="text" name="{{ $fieldKey }}"></td> -->
                            </tr>
                    <?php
                        }
                    ?>
                            <tr>
                                <td></td>
                                <td><button type="button" class="doSearch btn btn-sm btn-primary">Search</button>&nbsp;&nbsp;<a href="{{$url}}"><button type="button" class="btn btn-sm btn-warning">Reset</button></a></td>
                                <td></td>
                            </tr>
                    </tbody>     
                </table>
            </form>	
            <div style="display:none">
                <form id="filterdata">{{ csrf_field() }}
                    <input type="text" name="attribute" id="attr">
                    <input type="submit" name="submit" id="submit">
                </form>
            </div>
        </div>
    </div>
</div>
