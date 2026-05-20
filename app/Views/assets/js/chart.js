class Chart {
    constructor(ctx, config) {
        this.ctx = ctx instanceof CanvasRenderingContext2D ? ctx : ctx.getContext('2d');
        this.canvas = this.ctx.canvas;
        this.config = config;
        this.render();
    }
    render() {
        const type = this.config.type;
        const data = this.config.data;
        if (type === 'pie') this.drawPie(data);
        if (type === 'bar') this.drawBar(data);
    }
    drawPie(data) {
        const ctx = this.ctx;
        const values = data.datasets[0].data;
        const colors = data.datasets[0].backgroundColor || ['#2d5a3d', '#1a4f7a', '#b8750a'];
        const total = values.reduce((a, b) => a + b, 0);
        
        ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
        let startAngle = 0;
        const cx = this.canvas.width / 2;
        const cy = this.canvas.height / 2;
        const radius = Math.min(cx, cy) - 15;

        if (total === 0) {
            ctx.fillStyle = '#e5ece8';
            ctx.beginPath(); ctx.arc(cx, cy, radius, 0, 2 * Math.PI); ctx.fill();
            return;
        }
        values.forEach((val, i) => {
            const sliceAngle = (val / total) * 2 * Math.PI;
            ctx.fillStyle = colors[i % colors.length];
            ctx.beginPath(); ctx.moveTo(cx, cy);
            ctx.arc(cx, cy, radius, startAngle, startAngle + sliceAngle);
            ctx.closePath(); ctx.fill();
            startAngle += sliceAngle;
        });
    }
    drawBar(data) {
        const ctx = this.ctx;
        const labels = data.labels;
        const values = data.datasets[0].data;
        const max = Math.max(...values, 1);
        
        ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
        const w = this.canvas.width;
        const h = this.canvas.height;
        const barWidth = (w - 40) / labels.length;

        values.forEach((val, i) => {
            const barHeight = (val / max) * (h - 50);
            const x = 30 + i * barWidth;
            const y = h - 30 - barHeight;
            ctx.fillStyle = '#5fa876';
            ctx.fillRect(x + 8, y, barWidth - 16, barHeight);
            ctx.fillStyle = '#7a8f80';
            ctx.font = '11px DM Sans, sans-serif';
            ctx.fillText(labels[i].substring(0,3), x + barWidth/4, h - 10);
            ctx.fillText(val, x + barWidth/2 - 4, y - 8);
        });
    }
}