<div class="card-tools">
    <form class="form-horizontal" id="search" action="{{ $searchRoute }}" method="get">
        <div class="input-group input-group-sm" style="width: 150px;">
            <input type="text" name="q" class="form-control float-right" placeholder="Search">

            <div class="input-group-append">
                <button type="submit" class="btn btn-default">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>
</div>
