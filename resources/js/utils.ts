/**
 * Prints a PDF in a browser using a hidden iframe. Works in recent versions of Firefox, Chrome, Safari and Edge. Does
 * not work in IE 11 and instead attempts to open the PDF in a new tab.
 *
 * Note that the PDF URL must come from the same domain as the page including this file because of the same-origin
 * policy.
 *
 * Usage: printPdf(url)
 */
const isFirefox = /Gecko\/\d/.test(navigator.userAgent);
const firefoxDelay = 1000;
let iframe: HTMLIFrameElement | null = null;

export const printPdf = (url: string): void => {
    // Clean up previous iframe
    if (iframe?.parentNode) {
        iframe.parentNode.removeChild(iframe);
    }

    iframe = document.createElement("iframe");
    iframe.style.cssText = `
        width: 1px;
        height: 100px;
        position: fixed;
        left: 0;
        top: 0;
        opacity: 0;
        border-width: 0;
        margin: 0;
        padding: 0;
    `;

    const xhr = new XMLHttpRequest();

    try {
        xhr.responseType = "arraybuffer";
    } catch (error) {
        // Fallback for IE11
        window.open(url, "_blank");
        return;
    }

    xhr.addEventListener("load", () => {
        if (xhr.status !== 200 && xhr.status !== 201) return;

        const pdfBlob = new Blob([xhr.response], {type: "application/pdf"});
        const iframeUrl = URL.createObjectURL(pdfBlob);
        iframe!.src = iframeUrl;

        iframe!.addEventListener("load", () => {
            const printIframe = () => {
                try {
                    iframe!.focus();

                    try {
                        // Older browsers
                        iframe!.contentWindow!.document.execCommand("print", false, null);
                    } catch (error) {
                        // Modern browsers
                        iframe!.contentWindow!.print();
                    }
                } catch (error) {
                    console.error("Print failed:", error);
                } finally {
                    // Cleanup
                    if (iframe) {
                        iframe.style.visibility = "hidden";
                        iframe.style.left = "-1px";
                    }
                    URL.revokeObjectURL(iframeUrl);
                }
            };

            isFirefox
                ? setTimeout(printIframe, firefoxDelay)
                : printIframe();
        });

        document.body.appendChild(iframe!);
    });

    xhr.open("GET", url, true);
    xhr.send();
};
