import React, { useEffect } from 'react';
import ContentContainer from '@/components/elements/ContentContainer';
import { CSSTransition } from 'react-transition-group';
import tw from 'twin.macro';
import FlashMessageRender from '@/components/FlashMessageRender';

export interface PageContentBlockProps {
    title?: string;
    className?: string;
    showFlashKey?: string;
}

import Attribution from '@/blueprint/extends/Attribution';
import BeforeSection from '@/blueprint/components/Dashboard/Global/BeforeSection';
import AfterSection from '@/blueprint/components/Dashboard/Global/AfterSection';

const PageContentBlock: React.FC<PageContentBlockProps> = ({ title, showFlashKey, className, children }) => {
    useEffect(() => {
        if (title) {
            document.title = title;
        }
    }, [title]);

    return (
        <CSSTransition timeout={150} classNames={'fade'} appear in>
            <>
                <BeforeSection/>
                <ContentContainer css={tw`my-4 sm:my-10`} className={className}>
                    {showFlashKey && <FlashMessageRender byKey={showFlashKey} css={tw`mb-4`} />}
                    {children}
                </ContentContainer>
                <AfterSection/>
                <ContentContainer css={tw`mb-4`}>
                    <p css={tw`text-center text-neutral-500 text-xs`}>
                        <a
                            rel={'noopener nofollow noreferrer'}
                            href={'https://Software.cloa.su'}
                            target={'_blank'}
                            css={tw`no-underline text-neutral-500 hover:text-neutral-300`}
                        >
                            CLOA Software&reg;
                        </a>
                        &nbsp;&copy; 2025 - {new Date().getFullYear()}
                        
                        <Attribution />
                    </p>
                </ContentContainer>
                <div css={tw`mt-2 flex justify-center`}>
                            <iframe
                            src="https://status.cloa.su/badge?theme=dark"
                            width="250"
                            height="30"
                            style={{
                                display: 'block',
                                border: 'none',
                                filter: 'brightness(1.2)',
                                marginLeft: '69px', 
                            }}
                            frameBorder={0}
                            scrolling="no"
                            ></iframe>
                            </div>
            </>
        </CSSTransition>
    );
};

export default PageContentBlock;
