function Butler(public_key) {
    this.io = window.io;
    this.public_key = public_key;
    this.server = "http://butler-client.local:9999";
}

Butler.prototype.subscribe = function(channel) {
    if(typeof window.io === 'undefined') {
        console.error('You must include Socket.IO for this to work');
        return;
    }

    var query = 'public_key='+this.public_key+'&channel='+channel,
        io = this.io.connect(this.server, {query:query});

    return io;
}
