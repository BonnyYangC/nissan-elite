<form action="{{ route('faqs.store') }}" method="post" class="form" enctype="multipart/form-data">
    @csrf

    <div class="field is-horizontal">
        <div class="field-label is-normal">
            <label class="label">Question</label>
        </div>
        <div class="field-body">
            <div class="field">
                <div class="control">
                    <input class="input" type="text" name="question" placeholder="Question">
                </div>
            </div>
        </div>
    </div>

    <!--<div class="field is-horizontal">
        <div class="field-label is-normal">
            <label class="label">Order</label>
        </div>
        <div class="field-body">
            <div class="field">
                <div class="control">
                    <input class="input" type="text" name="sorting" placeholder="Order">
                </div>
            </div>
        </div>
    </div>-->

    <div class="field is-horizontal">
        <div class="field-label is-normal">
            <label class="label">Status</label>
        </div>
        <div class="field-body">
            <div class="field is-narrow">
                <div class="control">
                    <div class="select is-fullwidth">
                        <select name="status">
                            <option value="0" {{ $faq && !$faq->status ? 'selected' : null }}>Draft</option>
                            <option value="1" {{ $faq && $faq->status ? 'selected' : null }}>Published</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="field is-horizontal">
        <div class="field-label is-normal">
            <label class="label">Answer</label>
        </div>
        <div class="field-body">
            <div class="field">
                <div class="control">
                    <textarea class="textarea" name="answer" placeholder="Required: Answer" id="summernote" cols="30" rows="10"></textarea>
                </div>
            </div>
        </div>
    </div>

    <hr>
    <div class="field is-horizontal">
        <div class="field-label">
        </div>
        <div class="field-body">
            <div class="field">
                <div class="control">
                    <button class="button is-primary" type="submit">
                        <i id="submit-btn-waiting" class="fas fa-database"></i>&nbsp;&nbsp;&nbsp;
                        <span id="submit-btn-txt">Submit</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>