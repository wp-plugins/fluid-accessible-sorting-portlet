jQuery(document).ready(function () {
    fluid.reorderLayout ("#portlet-reorderer-root", {
        selectors: {
            columns: "td",
            modules: "td > div"
        }
    });
});
