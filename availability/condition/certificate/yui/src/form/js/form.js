M.availability_certificate = M.availability_certificate || {};

M.availability_certificate.form = Y.Object(M.core_availability.plugin);

M.availability_certificate.form.initInner = function(certificate_instances) {
    M.availability_certificate.certificate_instances = certificate_instances;

};

M.availability_certificate.form.getNode = function(json) {
    var html = M.util.get_string('has_issued', 'availability_certificate');
    html += '<select class="custom-select">';

    for (var i in M.availability_certificate.certificate_instances) {
        if (M.availability_certificate.certificate_instances.hasOwnProperty(i)) {
            var certificate_instance = M.availability_certificate.certificate_instances[i];
            if (json.certificate_id && json.certificate_id == certificate_instance.instance) {
                html += '<option value="' + certificate_instance.instance + '" selected>' + certificate_instance.name + '</option>';
            } else {
                html += '<option value="' + certificate_instance.instance + '">' + certificate_instance.name + '</option>';
            }
        }
    }

    html += '</select>';

    var strings = M.str.availability_certificate;
    var node = Y.Node.create('<span>' + html + '</span>');

    if (!M.availability_certificate.form.addedEvents) {
        M.availability_certificate.form.addedEvents = true;
        var root = Y.one('.availability-field');
        root.delegate('click', function() {
            M.core_availability.form.update();
        }, '.availability_certificate select');
    }

    return node;
};

M.availability_certificate.form.fillValue = function(value, node) {
    node.one('select').get("options").each( function() {
        if (this.get('selected')) {
            value.certificate_id = this.get('value');
        }
    });
};

M.availability_certificate.form.fillErrors = function(errors, node) {
    if (false) {
        errors.push('availability_certificate:error_message');
    }
};