<nav class="d-flex justify-items-center justify-content-between">
    <div class="d-flex justify-content-between flex-fill d-sm-none">
        <ul class="pagination">
            <li class="page-item disabled" aria-disabled="true">
                <span class="page-link">« Previous</span>
            </li>
            <li class="page-item">
                <a class="page-link" href="admin/repositories/pending/filter/all?sort=desc&amp;search=&amp;status=all&amp;page=2" rel="next">Next »</a>
            </li>
        </ul>
    </div>

    <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
        <div>
            <p class="small text-muted">
                Showing
                <span class="fw-semibold">{{ ($currentPage - 1) * $perPage + 1 }}</span>
                to
                <span class="fw-semibold">{{ min($currentPage * $perPage, $total) }}</span>
                of
                <span class="fw-semibold">{{ $total }}</span>
                results
            </p>
        </div>

        <div>
            <ul class="pagination">
                <li class="page-item disabled" aria-disabled="true" aria-label="« Previous">
                    <span class="page-link" aria-hidden="true">‹</span>
                </li>
                <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
                <li class="page-item disabled">
                    <a class="page-link" href="admin/repositories/pending/filter/all?sort=desc&amp;search=&amp;status=all&amp;page=2" rel="next" aria-label="Next »">›</a>
                </li>
            </ul>
        </div>
    </div>
</nav>