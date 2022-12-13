import React from "react";
import { Link } from "@inertiajs/inertia-react";

export default function Pagination({ links, totals }) {
    // const prev = links[0].url;
    // const next = links[links.length - 1].url;
    function getClassName(active) {
        if (active) {
            return "mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-primary focus:text-primary bg-blue-700 text-white";
        } else {
            return "mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-primary focus:text-primary";
        }
    }

    return (
        links.length > 3 && (
            <div className="mb-4  px-5 flex justify-between items-center ">
                <p className="text-sm text-gray-400">{totals} items</p>
                <div className="flex  mt-3">
                    {links.map((link, key) =>
                        link.url === null ? (
                            <div
                                key={key}
                                className="mr-1 mb-1 px-4 py-3 text-sm leading-4 bg-white border rounded"
                            >
                                {link.label}
                            </div>
                        ) : (
                            <Link
                                key={key}
                                className={getClassName(link.active)}
                                href={link.url}
                            >
                                {link.label}
                            </Link>
                        )
                    )}
                </div>
            </div>
        )
    );
}
