export default {
    data() {
        return {
            selected: [],
            selectedItem: false,
            roles: ["personnel", "admin"],
            perpages: [1, 5, 10, 25, 50, 100],
            options: [
                {
                    option: "",
                    is_correct: false,
                    img_path: "",
                },
                {
                    option: "",
                    is_correct: false,
                    img_path: "",
                },
                {
                    option: "",
                    is_correct: false,
                    img_path: "",
                },
                {
                    option: "",
                    is_correct: false,
                    img_path: "",
                },
            ],
            status: ["active", "inactive"],
            categories: ["Requirements", "Admission", "Courses", "Contact Information", "Other"],
            qualifications: ["pending", "qualified", "not qualified"],
        };
    },
    methods: {
        selectItem: function (item) {
            this.selectedItem = item;
        },
        unSelectItem: function (item) {
            this.selectedItem = false;
        },

        getRoles: function () {
            let urlParams = new URLSearchParams(window.location.search);
            return urlParams.get("roles");
        },

        getPerPage: function () {
            let urlParams = new URLSearchParams(window.location.search);
            return urlParams.get("perpages");
        },

        getStatus: function () {
            let urlParams = new URLSearchParams(window.location.search);
            return urlParams.get("status");
        },

        getCategories: function () {
            let urlParams = new URLSearchParams(window.location.search);
            return urlParams.get("categories");
        },

        getQualifications: function () {
            let urlParams = new URLSearchParams(window.location.search);
            return urlParams.get("qualifications");
        },
    },
};
