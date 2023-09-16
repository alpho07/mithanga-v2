@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.expense.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.expenses.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('expense_category_id') ? 'has-error' : '' }}">
                <label for="expense_category">{{ trans('cruds.expense.fields.expense_category') }}</label>
                <select name="expense_category_id" id="expense_category" class="form-control select2">
                    @foreach($expense_categories as $id => $expense_category)
                    <option value="{{ $id }}" {{ (isset($expense) && $expense->expense_category ? $expense->expense_category->id : old('expense_category_id')) == $id ? 'selected' : '' }}>{{ $expense_category }}</option>
                    @endforeach
                </select>
                @if($errors->has('expense_category_id'))
                <em class="invalid-feedback">
                    {{ $errors->first('expense_category_id') }}
                </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('entry_date') ? 'has-error' : '' }}">
                <label for="entry_date">{{ trans('cruds.expense.fields.entry_date') }}*</label>
                <input type="text" id="entry_date" name="entry_date" class="form-control date" value="{{ old('entry_date', isset($expense) ? $expense->entry_date : '') }}" required>
                @if($errors->has('entry_date'))
                <em class="invalid-feedback">
                    {{ $errors->first('entry_date') }}
                </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.expense.fields.entry_date_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                <label for="description">{{ trans('cruds.expense.fields.description') }}</label>
                <input type="text" id="description" name="description" class="form-control" value="{{ old('description', isset($expense) ? $expense->description : '') }}">
                @if($errors->has('description'))
                <em class="invalid-feedback">
                    {{ $errors->first('description') }}
                </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.expense.fields.description_helper') }}
                </p>
            </div> <div class="form-group {{ $errors->has('account_number') ? 'has-error' : '' }}">
                <label for="account_number">{{ trans('cruds.expense.fields.description_no') }}</label>
                <input type="text" id="account_number" name="account_number" class="form-control" value="{{ old('account_number', isset($expense) ? $expense->account_number : '') }}">
                @if($errors->has('account_number'))
                <em class="invalid-feedback">
                    {{ $errors->first('account_number') }}
                </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.expense.fields.description_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('phone_number') ? 'has-error' : '' }}">
                <label for="phone_number">Phone Number</label>
                <input type="text" id="phone_number" name="phone_number" class="form-control" value="{{ old('phone_number', isset($expense) ? $expense->phone_number : '') }}">
                @if($errors->has('phone_number'))
                <em class="invalid-feedback">
                    {{ $errors->first('phone_number') }}
                </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.expense.fields.description_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}">
                <label for="amount">{{ trans('cruds.expense.fields.amount') }}*</label>
                <input type="number" id="amount" name="amount" class="form-control" value="{{ old('amount', isset($expense) ? $expense->amount : '') }}" step="0.01" required>
                @if($errors->has('amount'))
                <em class="invalid-feedback">
                    {{ $errors->first('amount') }}
                </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.expense.fields.amount_helper') }}
                </p>
            </div>

            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>


    </div>
</div>
@endsection